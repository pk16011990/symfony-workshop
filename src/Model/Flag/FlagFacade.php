<?php
declare(strict_types=1);

namespace App\Model\Flag;

use App\Entity\Flag;
use Doctrine\ORM\EntityManagerInterface;

class FlagFacade
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \App\Entity\Flag[]
     */
    public function getAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('f')
            ->from(Flag::class, 'f')
            ->orderBy('f.name')
            ->getQuery()
            ->execute();
    }
}