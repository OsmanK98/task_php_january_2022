<?php

namespace App\Application\QueryHandler\Album;

use App\Application\Query\Album\ListAlbumsQuery;
use App\Application\QueryHandler\QueryHandlerInterface;
use App\Repository\AlbumRepository;

class ListAlbumsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AlbumRepository $albumRepository)
    {

    }

    public function __invoke(ListAlbumsQuery $query): array
    {
        return $this->albumRepository->findAll();
    }
}
