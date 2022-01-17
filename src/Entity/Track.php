<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        'track:output',
        'album:output:item'
    ])]
    private int $id;

    #[Assert\NotBlank(message: 'The title cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The name of track is too long!")]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'track:output',
        'album:output:item'
    ])]
    private string $title;

    #[Assert\NotBlank(message: 'The URL cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The URL is too long!")]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'track:output',
        'album:output:item'
    ])]
    private string $url;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['track:output'])]
    private Album $album;

    public function __construct(string $title, string $url, Album $album)
    {
        $this->title = $title;
        $this->url = $url;
        $this->album = $album;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function setAlbum(Album $album): void
    {
        $this->album = $album;
    }
}
