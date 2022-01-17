<?php

namespace App\Application\Command\Band;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteBandCommand
{
    #[Assert\NotBlank(message: 'The band ID field cannot be empty!')]
    private ?int $bandId;

    public function __construct(?int $bandId)
    {
        $this->bandId = $bandId;
    }

    public function getBandId(): ?int
    {
        return $this->bandId;
    }
}
