<?php

namespace App\Application\Command\Band;

use Symfony\Component\Validator\Constraints as Assert;

class CreateBandCommand
{
    #[Assert\NotBlank(message: 'The name cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The name is too long!")]
    private ?string $name;

    public function __construct(?string $name)
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
