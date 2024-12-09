<?php

namespace App\Repositories;

use App\Entities\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;

class ContactMessageRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function save(ContactMessage $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(ContactMessage::class)
            ->findBy([], ['createdAt' => 'DESC']);
    }
}
