<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class AbstractManager
{
    /**
     * @var EntityManagerInterface $em
     */
    protected $em;

    /**
     * @var SerializerInterface $serializer
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
     * @param SerializerInterface    $serializer
     * @param string                 $className
     */
    public function __construct(EntityManagerInterface $em, $serializer, string $className)
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

        return $this->serialize($exist, ['get']);
    }

    /**
     * @param array $data
     *
     * @return array|object
     */
    public function create(array $data)
    {
        $entity = $this->deserialize($data);
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

        $entity = $this->deserialize($data, [], $exist);
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
     * @param mixed $objectToPopulate
     *
     * @return array|object
     */
    protected function deserialize(array $data, array $groups = [], $objectToPopulate = null)
    {
        return  $this->serializer->deserialize(json_encode($data), $this->repositoryNamespace, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $objectToPopulate]);

    }

    /**
     * @param       $data
     * @param array $groups
     *
     * @return string
     */
    protected function serialize($data, array $groups = [])
    {
        return  $this->serializer->serialize($data,'json', ['groups' => $groups]);

    }
}
