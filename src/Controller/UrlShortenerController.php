<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ShortenedUrl;
use App\Repository\ShortenedUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class UrlShortenerController extends AbstractController
{
    public function __construct(
        private readonly ShortenedUrlRepository $repository
    )
    {
    }

    #[Route('/api/url/shorten', name: 'shorten-url', methods: 'POST')]
    public function __invoke(Request $request): Response
    {
        try {
            $url = $this->extractUrlFromRequest($request);
            $shortCode = $this->generateShortCodeFromUrl($url);
            $this->persistShortenedUrl($shortCode, $url);
        } catch (BadRequestHttpException $exception) {
            return new JsonResponse(
                json_encode(['error' => $exception->getMessage()]),
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([
                'data' => [
                    'shortened_url' => sprintf('https://%s/%s', $request->getHost(), $shortCode)
                ]
            ]
        );
    }

    private function extractUrlFromRequest(Request $request): string
    {
        try {
            $jsonContent = $request->getContent();
            $data = json_decode($jsonContent, true);

            return $data['url'];
        } catch (Throwable) {
            throw new BadRequestHttpException('Invalid payload. A url must be provided.');
        }
    }

    private function generateShortCodeFromUrl(string $url): string
    {
        $hash = hash('sha256', $url);

        return substr($hash, 8, 7);
    }

    private function persistShortenedUrl(string $shortCode, string $url): void
    {
        $shortenedUrl = ShortenedUrl::create($shortCode, $url);
        $this->repository->save($shortenedUrl);
    }
}
