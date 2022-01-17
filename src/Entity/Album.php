<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        'album:output:collection',
        'album:output:item',
        'band:output',
        'track:output'
    ])]
    private int $id;

    #[Assert\NotBlank(message: 'The title cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The title is too long!")]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'album:output:collection',
        'album:output:item',
        'band:output',
        'track:output'
    ])]
    private string $title;

    #[Assert\NotBlank(message: 'The cover cannot be empty!')]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'album:output:collection',
        'album:output:item',
        'band:output',
        'track:output'
    ])]
    private string $cover;

    #[Assert\NotBlank(message: 'The year cannot be empty!')]
    #[Assert\Length(min: 4, max: 4, exactMessage: 'The year should have exactly 4 characters!')]
    #[ORM\Column(type: 'string', length: 4)]
    #[Groups([
        'album:output:collection',
        'album:output:item',
        'band:output',
        'track:output'
    ])]
    private string $year;

    #[Assert\NotBlank(message: 'The promoted field cannot be empty!')]
    #[ORM\Column(type: 'boolean')]
    #[Groups([
        'album:output:collection',
        'album:output:item',
        'band:output',
        'track:output'
    ])]
    private bool $isPromoted;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Track::class, cascade: ['remove'])]
    #[Groups(['album:output:item'])]
    private PersistentCollection|ArrayCollection $tracks;

    #[ORM\ManyToOne(targetEntity: Band::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'album:output:item',
        'album:output:collection',
        'track:output'
    ])]
    private Band $band;

    public function __construct(string $title, string $cover, string $year, bool $isPromoted, Band $band)
    {
        $this->title = $title;
        $this->cover = $cover;
        $this->year = $year;
        $this->isPromoted = $isPromoted;
        $this->band = $band;
        $this->tracks = new ArrayCollection();
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

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getIsPromoted(): ?bool
    {
        return $this->isPromoted;
    }

    public function setIsPromoted(bool $isPromoted): self
    {
        $this->isPromoted = $isPromoted;

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): self
    {
        $this->band = $band;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): self
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks[] = $track;
            $track->setAlbum($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getAlbum() === $this) {
                $track->setAlbum(null);
            }
        }

        return $this;
    }
}
