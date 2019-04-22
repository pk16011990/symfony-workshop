<?php
declare(strict_types=1);

namespace App\Controller;

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form(Request $request): Response
    {
        $form = $this->createForm(ProductForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Product/form.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}