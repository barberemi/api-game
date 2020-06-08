<?php

namespace App\Manager;

/**
 * Class CircularReferenceHandler
 */
class CircularReferenceHandler
{
    /**
     * @param mixed $object
     *
     * @return mixed
     */
    public function __invoke($object)
    {
        return $object->getId();
    }
}
