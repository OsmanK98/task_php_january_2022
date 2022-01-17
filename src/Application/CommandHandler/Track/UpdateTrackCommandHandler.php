<?php

namespace App\Application\CommandHandler\Track;

use App\Application\Command\Track\UpdateTrackCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Album;
use App\Entity\Track;
use App\Repository\AlbumRepository;
use App\Repository\TrackRepository;
use App\Service\ValidatorObjectService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateTrackCommandHandler implements CommandHandlerInterface
{
    public function __construct(private TrackRepository        $trackRepository,
                                private AlbumRepository        $albumRepository,
                                private ValidatorObjectService $validator)
    {

    }

    public function __invoke(UpdateTrackCommand $command)
    {
        $album = $this->albumRepository->findOneBy(['id' => $command->getAlbumId()]);

        if (!$album instanceof Album) {
            throw new NotFoundHttpException('Not found the album!');
        }

        $track = $this->trackRepository->findOneBy(['id' => $command->getTrackId()]);

        if (!$track instanceof Track) {
            throw new NotFoundHttpException('Not found!');
        }

        $track->setTitle($command->getTitle());
        $track->setAlbum($album);
        $track->setUrl($command->getUrl());

        $this->validator->validate($track);
        $this->trackRepository->update($track);
    }
}
