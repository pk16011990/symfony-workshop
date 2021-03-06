<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Product\ProductFacade;
use App\Model\Product\ProductForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("product/form")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Model\Product\ProductFacade $productFacade
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form(Request $request, ProductFacade $productFacade): Response
    {
        $form = $this->createForm(ProductForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productFacade->create($form->getData());

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Product/form.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    public function topOffer(ProductFacade $productFacade): Response
    {
        $products = $productFacade->getAllVisible();

        return $this->render('Prouct/topOffer.html.twig', [
            'products' => $products,
        ]);
    }
}