<?php
declare(strict_types=1);

namespace App\Model\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

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
     * @var \Symfony\Component\Stopwatch\Stopwatch|null
     */
    private $stopwatch;

    /**
     * @param \Symfony\Component\Stopwatch\Stopwatch|null $stopwatch
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Model\Product\ProductRepository $productRepository
     */
    public function __construct(
        ?Stopwatch $stopwatch,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    ) {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->stopwatch = $stopwatch;
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
        if ($this->stopwatch !== null) {
            $this->stopwatch->start('getProducts');
        }
        $products = $this->productRepository->getAllVisible();
        if ($this->stopwatch !== null) {
            $this->stopwatch->stop('getProducts');
        }

        return $products;
    }
}