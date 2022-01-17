<?php

namespace App\Application\CommandHandler\Track;

use App\Application\Command\Track\DeleteTrackCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteTrackCommandHandler implements CommandHandlerInterface
{
    public function __construct(private TrackRepository $trackRepository)
    {
    }

    public function __invoke(DeleteTrackCommand $command)
    {
        $track = $this->trackRepository->findOneBy(['id' => $command->getTrackId()]);

        if (!$track instanceof Track) {
            throw new NotFoundHttpException('Not found!');
        }

        $this->trackRepository->remove($track);
    }
}
