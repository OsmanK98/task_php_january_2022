<?php

namespace App\Application\CommandHandler\Track;

use App\Application\Command\Track\CreateTrackCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Album;
use App\Entity\Track;
use App\Repository\AlbumRepository;
use App\Repository\TrackRepository;
use App\Service\ValidatorObjectService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateTrackCommandHandler implements CommandHandlerInterface
{
    public function __construct(private TrackRepository        $trackRepository,
                                private AlbumRepository        $albumRepository,
                                private ValidatorObjectService $validator)
    {

    }

    public function __invoke(CreateTrackCommand $command)
    {
        $album = $this->albumRepository->findOneBy(['id' => $command->getAlbumId()]);

        if (!$album instanceof Album) {
            throw new NotFoundHttpException('Not found!');
        }

        $track = new Track(
            $command->getTitle(),
            $command->getUrl(),
            $album
        );

        $this->validator->validate($track);
        $this->trackRepository->add($track);
    }
}
