<?php

namespace App\Application\QueryHandler\Album;

use App\Application\Query\Album\ShowAlbumQuery;
use App\Application\QueryHandler\QueryHandlerInterface;
use App\Entity\Album;
use App\Repository\AlbumRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowAlbumQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AlbumRepository $albumRepository)
    {

    }

    public function __invoke(ShowAlbumQuery $query): Album
    {
        $album = $this->albumRepository->findOneBy(['id' => $query->getId()]);

        if (!$album instanceof Album) {
            throw new NotFoundHttpException('Not found!');
        }

        return $album;
    }
}
