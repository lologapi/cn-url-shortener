<?php

namespace App\Repository;

use App\Entity\ShortenedUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShortenedUrlRepository extends ServiceEntityRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortenedUrl::class);
    }

    public function save(ShortenedUrl $shortenedUrl): void
    {
        $entityManager = $this->registry->getManager();
        $entityManager->persist($shortenedUrl);
        $entityManager->flush();
    }

}
