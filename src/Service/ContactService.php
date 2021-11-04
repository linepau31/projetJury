<?php

namespace App\Service;


use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService
{
    private $entityManager;
    private $flash;

    public function __construct(EntityManagerInterface $entityManager, FlashBagInterface $flash)
    {
        $this->entityManager = $entityManager;
        $this->flash = $flash;
    }

    public function persistContact(Contact $contact): void
    {
        $contact->setIsRead(false)
                ->setCreatedAt(new \DateTimeImmutable('now'));

        $this->entityManager->persist($contact);
        $this->entityManager->flush();
        $this->flash->add('notice', 'Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');
    }

    public function isRead(Contact $contact): void
    {
        $contact->setIsRead(true);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }

}