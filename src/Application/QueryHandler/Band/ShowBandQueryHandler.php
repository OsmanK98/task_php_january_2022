<?php

namespace App\Application\QueryHandler\Band;

use App\Application\Query\Band\ShowBandQuery;
use App\Application\QueryHandler\QueryHandlerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowBandQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BandRepository $bandRepository)
    {

    }

    public function __invoke(ShowBandQuery $query): Band
    {
        $band = $this->bandRepository->findOneBy(['id' => $query->getId()]);

        if (!$band instanceof Band) {
            throw new NotFoundHttpException('Not found!');
        }

        return $band;
    }
}
