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
     * @var \App\Model\Product\ProductRepository
     */
    private $productRepository;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Model\Product\ProductRepository $productRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
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
            $productData['hidden'],
            $productData['flags']
        );

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    /**
     * @return \App\Entity\Product[]
     */
    public function getAllVisible(): array
    {
        return $this->productRepository->getAllVisible();
    }
}