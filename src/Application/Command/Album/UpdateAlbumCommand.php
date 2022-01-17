<?php

namespace App\Application\Command\Album;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAlbumCommand
{
    #[Assert\NotBlank(message: 'The album ID field cannot be empty!')]
    private int $albumId;

    #[Assert\NotBlank(message: 'The title cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The name is too long!")]
    private ?string $title;

    #[Assert\NotBlank(message: 'The cover cannot be empty!')]
    private ?UploadedFile $cover;

    #[Assert\NotBlank(message: 'The year cannot be empty!')]
    #[Assert\Length(min: 4, max: 4, exactMessage: 'The year should have exactly 4 characters!')]
    private ?string $year;

    #[Assert\NotBlank(message: 'The promoted field cannot be empty!')]
    private ?bool $isPromoted;

    #[Assert\NotBlank(message: 'The band ID field cannot be empty!')]
    private ?int $bandId;


    public function __construct(?int          $albumId,
                                ?string       $title,
                                ?UploadedFile $cover,
                                ?string       $year,
                                ?bool         $isPromoted,
                                ?int          $bandId

    )
    {
        $this->albumId = $albumId;
        $this->title = $title;
        $this->cover = $cover;
        $this->year = $year;
        $this->isPromoted = $isPromoted;
        $this->bandId = $bandId;
    }

    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function getCover(): ?UploadedFile
    {
        return $this->cover;
    }

    public function isPromoted(): ?bool
    {
        return $this->isPromoted;
    }

    public function getBandId(): ?int
    {
        return $this->bandId;
    }
}
