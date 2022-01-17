<?php

namespace App\Application\Query\Album;

use Symfony\Component\Validator\Constraints as Assert;

class ShowAlbumQuery
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
