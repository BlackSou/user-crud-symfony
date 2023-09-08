<?php

namespace App\Repository;

use App\Entity\User;
use App\Exception\EmployeeNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function hasDuplicateEmail(string $email): bool
    {
        $result = $this->findOneBy(['email' => $email]);

        return null !== $result;
    }

    public function getUserById(int $id): User
    {
        $user = $this->find($id);
        if (null === $user) {
            throw new EmployeeNotFoundException();
        }

        return $user;
    }
}
