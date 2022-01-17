<?php

namespace App\Application\QueryHandler\Track;

use App\Application\Query\Track\ListTracksQuery;
use App\Application\QueryHandler\QueryHandlerInterface;
use App\Repository\TrackRepository;

class ListTracksQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TrackRepository $trackRepository)
    {
    }

    public function __invoke(ListTracksQuery $query): array
    {
        return $this->trackRepository->findAll();
    }
}
