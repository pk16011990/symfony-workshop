<?php
declare(strict_types=1);

namespace App\Model\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \App\Entity\Product[]
     */
    public function getAllVisible(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->where('p.hidden = FALSE')
            ->getQuery()
            ->execute();
    }

    /**
     * @return \App\Entity\Product[]
     */
    public function getAllVisiblePreloaded(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p, f')
            ->from(Product::class, 'p')
            ->leftJoin('p.flags', 'f')
            ->where('p.hidden = FALSE')
            ->getQuery()
            ->execute();
    }
}