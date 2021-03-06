<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route(name="homepage", path="/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepage(): Response
    {
        return $this->render('Homepage/homepage.html.twig');
    }

    /**
     * @Route(name="hello", path="/hello/{name}")
     */
    public function hello(string $name = 'nobody'): Response
    {
        return $this->render('Homepage/hello.html.twig', [
            'name' => $name,
        ]);
    }
}