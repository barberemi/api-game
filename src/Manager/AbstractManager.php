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

        return $this->serialize($exist);
    }

    /**
     * @param int $page
     *
     * @return array
     */
    public function getAll(int $page)
    {
        $entities = $this->em->getRepository($this->repositoryNamespace)->findByPageAndLimit($page);

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

        return $entity;
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return array|object
     *
     * @throws \Exception
     */
    public function update(int $id, array $data)
    {
        $exist  = $this->em->getRepository($this->repositoryNamespace)->find($id);

        if (!$exist) throw new \Exception(sprintf('Entity id %d doesnt exists.', $id));

        if(!array_key_exists('id', $data)) $data['id'] = $id;

        $entity = $this->deserialize($data, ['update']);
        $entity = $this->em->getRepository($this->repositoryNamespace)->update($entity);

        return $entity;
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
