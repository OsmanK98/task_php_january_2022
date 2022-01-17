<?php

namespace App\Application\Query\Band;

use Symfony\Component\Validator\Constraints as Assert;

class ShowBandQuery
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
