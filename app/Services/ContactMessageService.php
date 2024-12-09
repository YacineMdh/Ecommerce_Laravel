<?php

namespace App\Services;

use App\Entities\ContactMessage;
use App\Repositories\ContactMessageRepository;

class ContactMessageService
{
    public function __construct(
        private ContactMessageRepository $contactMessageRepository
    ) {}

    public function createMessage(array $data): ContactMessage
    {
        $message = new ContactMessage();
        $message->setName($data['name']);
        $message->setEmail($data['email']);
        $message->setMessage($data['message']);

        $this->contactMessageRepository->save($message);

        return $message;
    }

    public function getAllMessages(): array
    {
        return $this->contactMessageRepository->findAll();
    }
}
