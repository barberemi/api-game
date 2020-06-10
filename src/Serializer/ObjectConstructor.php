<?php

namespace App\Serializer;

use JMS\Serializer\AbstractVisitor;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;
use JMS\Serializer\VisitorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ObjectConstructor
 */
class ObjectConstructor implements ObjectConstructorInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Copy of JMS\Serializer\Construction\DoctrineObjectConstructor
     * The call to fallback is replaced by the "return new $className()"
     *
     * @param VisitorInterface       $visitor
     * @param ClassMetadata          $metadata
     * @param mixed                  $data
     * @param array                  $type
     * @param DeserializationContext $context
     *
     * @return null|object
     */
    public function construct(VisitorInterface $visitor, ClassMetadata $metadata, $data, array $type, DeserializationContext $context)
    {
        // Locate possible ObjectManager
        $objectManager = $this->managerRegistry->getManagerForClass($metadata->name);
        $className = $metadata->name;

        if (!$objectManager) {
            // No ObjectManager found, proceed with normal deserialization
            return new $className();
        }

        // Locate possible ClassMetadata
        $classMetadataFactory = $objectManager->getMetadataFactory();

        if ($classMetadataFactory->isTransient($metadata->name)) {
            // No ClassMetadata found, proceed with normal deserialization
            return new $className();
        }

        // Managed entity, check for proxy load
        if (!\is_array($data)) {
            // Single identifier, load proxy
            return $objectManager->getReference($metadata->name, $data);
        }

        // Fallback to default constructor if missing identifier(s)
        $classMetadata = $objectManager->getClassMetadata($metadata->name);
        $identifierList = array();

        foreach ($classMetadata->getIdentifierFieldNames() as $name) {
            if ($visitor instanceof AbstractVisitor) {
                /** @var PropertyNamingStrategyInterface $namingStrategy */
                $namingStrategy = $visitor->getNamingStrategy();
                $dataName = $namingStrategy->translateName($metadata->propertyMetadata[$name]);
            } else {
                $dataName = $name;
            }

            if (!array_key_exists($dataName, $data)) {
                return new $className();
            }

            $identifierList[$name] = $data[$dataName];
        }

        // Entity update, load it from database
        $object = $objectManager->find($metadata->name, $identifierList);

        if (null === $object) {
            return null;
        }

        $objectManager->initializeObject($object);

        return $object;
    }
}
