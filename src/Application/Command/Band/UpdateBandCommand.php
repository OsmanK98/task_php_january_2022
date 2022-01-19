<?php

namespace App\Application\Command\Band;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateBandCommand
{
    #[Assert\NotBlank(message: 'The band ID field cannot be empty!')]
    private ?int $bandId;

    #[Assert\NotBlank(message: 'The name cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The name is too long!")]
    private ?string $name;

    public function __construct(
        ?int $bandId,
        ?string $name
    ) {
        $this->bandId = $bandId;
        $this->name = $name;
    }

    public function getBandId(): ?int
    {
        return $this->bandId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
