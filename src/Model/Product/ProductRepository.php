<?php
declare(strict_types=1);

namespace App\Model\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

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

    /**
     * @return \App\Entity\Product[]
     */
    public function getAllVisiblePreloadedCached(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p, f')
            ->from(Product::class, 'p')
            ->leftJoin('p.flags', 'f')
            ->where('p.hidden = FALSE')
            ->getQuery()
            ->useResultCache(true, 3600)
            ->execute();
    }

    /**
     * @return array
     */
    public function getAllVisibleNativeQuery(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('price', 'price');
        $rsm->addScalarResult('concatenatedFlags', 'concatenatedFlags');

        $productsRows = $this->entityManager->createNativeQuery(
            'SELECT p.name, p.price, GROUP_CONCAT(f.name) as concatenatedFlags
                FROM product p 
                LEFT JOIN product_flag pf ON pf.product_id = p.id
                LEFT JOIN flag f ON f.id = pf.flag_id
                WHERE p.hidden = FALSE
                GROUP BY p.id
            ', $rsm)
            ->execute();

        // mess code, but only for fake structure like entities
        foreach ($productsRows as $key => $productsRow) {
            $concatenatedFlags = $productsRow['concatenatedFlags'] ?: '';
            $productsRows[$key]['flags'] = array_map(function ($flagName) {
                return ['name' => $flagName];
            }, explode(',', $concatenatedFlags));
        }

        return $productsRows;
    }

    /**
     * @return array
     */
    public function getAllVisibleNativeQueryCached(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('price', 'price');
        $rsm->addScalarResult('concatenatedFlags', 'concatenatedFlags');

        $productsRows = $this->entityManager->createNativeQuery(
            'SELECT p.name, p.price, GROUP_CONCAT(f.name) as concatenatedFlags
                FROM product p 
                LEFT JOIN product_flag pf ON pf.product_id = p.id
                LEFT JOIN flag f ON f.id = pf.flag_id
                WHERE p.hidden = FALSE
                GROUP BY p.id
            ', $rsm)
            ->useResultCache(true, 3600)
            ->execute();

        // mess code, but only for fake structure like entities
        foreach ($productsRows as $key => $productsRow) {
            $concatenatedFlags = $productsRow['concatenatedFlags'] ?: '';
            $productsRows[$key]['flags'] = array_map(function ($flagName) {
                return ['name' => $flagName];
            }, explode(',', $concatenatedFlags));
        }

        return $productsRows;
    }
}