<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 01:06
 */

namespace App\Service;

use App\Exception\EntityInvalidException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CRUDHelper
 * @package App\Service
 */
class CRUDHelper
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        NormalizerInterface $normalizer,
        Hydrator $hydrator
    )
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->normalizer = $normalizer;
        $this->hydrator = $hydrator;
    }

    /**
     * @param int $id
     * @param string $entityClass
     * @param $params
     * @return array|bool|float|int|string
     */
    public function show(int $id, string $entityClass, $params)
    {
        $entity = $this->em->getRepository($entityClass)->find($id);

        return $this->normalizer->normalize(
            $entity,
            'json',
            $params
        );
    }

    /**
     * @param string $entityClass
     * @param array $params
     * @throws EntityInvalidException
     * @throws \ReflectionException
     */
    public function create(string $entityClass, array $params): void
    {
        $entity = $this->hydrator->hydrate($entityClass, $params);

        $this->validate($entity);
        $this->save($entity);
    }

    /**
     * @param int $id
     * @param string $entityClass
     * @param array $params
     * @throws EntityInvalidException
     * @throws \ReflectionException
     */
    public function edit(int $id, string $entityClass, array $params): void
    {
        $entity = $this->em->getRepository($entityClass)->find($id);
        $this->hydrator->hydrate($entity, $params);

        $this->validate($entity);
        $this->save($entity);
    }

    /**
     * @param int $id
     * @param string $entityClass
     */
    public function delete(int $id, string $entityClass): void
    {
        $entity = $this->em->getRepository($entityClass)->find($id);

        if (!$entity) {
            return;
        }

        $this->em->remove($entity);

        $this->save($entity);
    }

    /**
     * @param $entity
     * @throws EntityInvalidException
     */
    private function validate($entity)
    {
        $errors = $this->validator->validate($entity);

        if (count($errors)) {
            $validationErrors = [];
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $validationErrors[] = $error->getMessage();
            }

            throw new EntityInvalidException(implode(', ', $validationErrors));
        }
    }

    /**
     * @param $object
     */
    private function save($object): void
    {
        $this->em->persist($object);
        $this->em->flush();
    }
}