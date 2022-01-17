<?php

namespace App\Application\Command\Track;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteTrackCommand
{
    #[Assert\NotBlank(message: 'The track ID field cannot be empty!')]
    private ?int $trackId;

    public function __construct(?int $trackId)
    {
        $this->trackId = $trackId;
    }

    public function getTrackId(): ?int
    {
        return $this->trackId;
    }
}
