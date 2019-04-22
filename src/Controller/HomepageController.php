<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController
{
    /**
     * @Route(name="homepage", path="/")
     */
    public function homepage(): Response
    {
        return new Response('Hello all');
    }

    /**
     * @Route(name="hello", path="/hello/{name}")
     */
    public function hello(string $name = 'nobody'): Response
    {
        return new Response('Hello ' . $name);
    }
}