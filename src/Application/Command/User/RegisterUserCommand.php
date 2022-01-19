<?php

namespace App\Application\Command\User;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserCommand
{
    #[Assert\NotBlank(message: 'The email cannot be empty!')]
    #[Assert\Email(message: 'Format of email is invalid')]
    private ?string $email;

    #[Assert\NotBlank(message: 'The password cannot be empty!')]
    #[Assert\Length(min: 8, minMessage: 'The password must be at least 8 characters!')]
    private ?string $password;

    public function __construct(
        ?string $email,
        ?string $password
    ) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
