<?php

namespace App\Application\Command\Mailer;

class SendEmailCommand
{
    public function __construct(
        private string $title,
        private string $description,
        private string $email
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
