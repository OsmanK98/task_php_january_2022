<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        'band:output',
        'album:output:collection',
        'album:output:item',
        'track:output'])]
    private int $id;

    #[Assert\NotBlank(message: 'The name cannot be empty!')]
    #[Assert\Length(max: 255, maxMessage: "The name of band is too long!")]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'band:output',
        'album:output:collection',
        'album:output:item',
        'track:output'
    ])]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'band', targetEntity: Album::class, cascade: ['remove'])]
    #[Groups(['band:output'])]
    private PersistentCollection|ArrayCollection $albums;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setBand($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getBand() === $this) {
                $album->setBand(null);
            }
        }

        return $this;
    }
}
