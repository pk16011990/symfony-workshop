<?php
declare(strict_types=1);

namespace App\Model\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductFacade
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
     * @param array $productData
     * @return \App\Entity\Product
     */
    public function create(array $productData): Product
    {
        $product = new Product(
            $productData['name'],
            (string)$productData['price'],
            $productData['hidden']
        );

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}