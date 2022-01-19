<?php

namespace App\Application\Command\Track;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateTrackCommand
{
    #[Assert\NotBlank(message: 'The track ID field cannot be empty!')]
    private ?int $trackId;

    #[Assert\NotBlank(message: 'The title cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The title is too long!")]
    private ?string $title;

    #[Assert\NotBlank(message: 'The URL cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The URL is too long!")]
    private ?string $url;

    #[Assert\NotBlank(message: 'The album ID field cannot be empty!')]
    private ?int $albumId;

    public function __construct(
        ?int $trackId,
        ?string $title,
        ?string $url,
        ?int $albumId
    ) {
        $this->trackId = $trackId;
        $this->title = $title;
        $this->url = $url;
        $this->albumId = $albumId;
    }

    public function getTrackId(): ?int
    {
        return $this->trackId;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }
}
