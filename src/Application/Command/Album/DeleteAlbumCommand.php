<?php

namespace App\Application\Command\Album;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteAlbumCommand
{
    #[Assert\NotBlank(message: 'The album ID field cannot be empty!')]
    private ?int $albumId;

    public function __construct(?int $albumId)
    {
        $this->albumId = $albumId;
    }

    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }
}
