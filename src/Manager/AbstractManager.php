<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Exception\ObjectConstructionException;
use JMS\Serializer\Serializer;

class AbstractManager
{
    /**
     * @var EntityManagerInterface $em
     */
    protected $em;

    /**
     * @var Serializer $serializer
     */
    protected $serializer;

    /**
     * @var string $repositoryNamespace
     */
    protected $repositoryNamespace;

    /**
     * AbstractManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param Serializer             $serializer
     * @param string                 $className
     */
    public function __construct(EntityManagerInterface $em, Serializer $serializer, string $className)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->repositoryNamespace = $this->em->getRepository($className)->getEntityNameSpace();
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws \Exception
     */
    public function get(int $id)
    {
        $exist  = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$exist) throw new \Exception(sprintf('Entity id %d doesnt exists.', $id));

        return json_decode($this->serialize($exist));
    }

    /**
     * @param null|array $criteria
     *
     * @return array
     */
    public function getAll(?array $criteria)
    {
        $order = "ASC";
        $newOrder = null;
        $orderBy = null;
        $limit = null;

        if ($criteria) {
            foreach ($criteria as $key => $value) {
                // Order and Order_by in querystring url
                if ($key === "order") {
                    $order = $value;
                    unset($criteria[$key]);
                    continue;
                }
                if ($key === "order_by") {
                    $orderBy = $value;
                    unset($criteria[$key]);
                    continue;
                }
                // Limit in querystring url
                if ($key === 'limit') {
                    $limit = $value;
                    unset($criteria[$key]);
                    continue;
                }
                if ($value === 'null') {
                    $criteria[$key] = null;
                }
            }
            if (isset($order) && isset($orderBy)) {
                $newOrder = [$orderBy => $order];
            }

            $entities = $this->em->getRepository($this->repositoryNamespace)->findBy($criteria, $newOrder, $limit);
        } else {
            $entities = $this->em->getRepository($this->repositoryNamespace)->findAll();
        }

        $data = ['items' => []];
        foreach ($entities as $entity) {
            $data['items'][] = json_decode($this->serialize($entity));
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return array|mixed
     *
     * @throws \Exception
     */
    public function create(array $data)
    {
        $entity = $this->deserialize($data, ['create']);
        $entity = $this->em->getRepository($this->repositoryNamespace)->create($entity);

        return json_decode($this->serialize($entity));
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function update(int $id, array $data)
    {
        $exist  = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$exist) throw new \Exception(sprintf('Entity id %d doesnt exists.', $id));

        if(!array_key_exists('id', $data)) $data['id'] = $id;

        $entity = $this->deserialize($data, ['update']);
        $entity = $this->em->getRepository($this->repositoryNamespace)->update($entity);

        return json_decode($this->serialize($entity));
    }

    /**
     * @param int $id
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $exist  = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$exist) throw new \Exception(sprintf('Entity id %d doesnt exists.', $id));

        $entity = $this->em->getRepository($this->repositoryNamespace)->delete($exist);

        return $entity;
    }

    /**
     * @param array $data
     * @param array $groups
     *
     * @return array|mixed
     *
     * @throws \Exception
     */
    protected function deserialize(array $data, array $groups)
    {
        try {
            return $this->serializer->fromArray(
                $data,
                $this->repositoryNamespace,
                DeserializationContext::create()->setGroups($groups)
            );
        } catch (ObjectConstructionException $e) {
            throw new \Exception(['message' => $e->getMessage()]);
        }
    }

    /**
     * @param $data
     *
     * @return string
     */
    protected function serialize($data)
    {
        return  $this->serializer->serialize($data,'json');

    }
}
