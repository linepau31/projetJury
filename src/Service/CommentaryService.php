<?php

namespace App\Service;

use App\Entity\Blogpost;
use App\Entity\Commentary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentaryService
{
    private $entityManager;
    private $flashBag;

    public function __construct(EntityManagerInterface $entityManager, FlashBagInterface $flashBag)
    {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    public function persistCommentary(
        Commentary $commentary,
        Blogpost $blogpost = null): void
    {
        $commentary->setIsPublished(false)
                    ->setBlogpost($blogpost)
                    ->setCreatedAt(new \DateTimeImmutable('now'));

        $this->entityManager->persist($commentary);
        $this->entityManager->flush();
        $this->flashBag->add('success', 'Votre commentaire est bien envoyé, merci. Il sera publié après validation.');
    }
}