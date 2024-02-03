<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final readonly class UrlShortenerController
{
    #[Route('/shorten-url', name: 'shorten_url', methods: 'GET')]
    public function __invoke(): Response
    {
        return new Response('Hello, World!');
    }
}
