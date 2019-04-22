<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController
{
    /**
     * @Route(name="homepage", path="/")
     */
    public function homepage(Request $request): Response
    {
        return new Response('Hello ' . $request->get('name', 'nobody'));
    }
}