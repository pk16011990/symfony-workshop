<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Product\ProductForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("product/form")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form(): Response
    {
        $form = $this->createForm(ProductForm::class);

        return $this->render('Product/form.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}