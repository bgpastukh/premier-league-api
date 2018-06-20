<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 02:21
 */

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Hydrator
{
    private const TARGET_ENTITY_PATTERN = '/(targetEntity="(.*)")/';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed $entity
     * @param array $params
     * @return object
     * @throws \ReflectionException
     */
    public function hydrate($entity, array $params)
    {
        /** @var \ReflectionClass $reflectionClass */
        $reflectionClass = new \ReflectionClass($entity);
        $object = is_object($entity) ? $entity : $reflectionClass->newInstanceWithoutConstructor();

        foreach ($params as $key => $value) {
            $property = $reflectionClass->getProperty($key);

            if (!$property->isPublic()) {
                $property->setAccessible(true);
            }

            // If property is not scalar, but mapped entity - get it from repository
            preg_match(self::TARGET_ENTITY_PATTERN, $property->getDocComment(), $matches);
            if ($matches) {
                $relationEntity = $matches[2];
                $value = $this->em->getRepository($relationEntity)->find($value);

                $property->setValue($object, $value);
            } else {
                $property->setValue($object, $value);
            }
        }

        return $object;
    }
}