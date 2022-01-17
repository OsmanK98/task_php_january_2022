<?php

namespace App\Application\CommandHandler\Album;

use App\Application\Command\Album\DeleteAlbumCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Album;
use App\Repository\AlbumRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteAlbumCommandHandler implements CommandHandlerInterface
{
    public function __construct(private AlbumRepository $albumRepository
    )
    {

    }

    public function __invoke(DeleteAlbumCommand $command)
    {
        $album = $this->albumRepository->findOneBy(['id' => $command->getAlbumId()]);

        if (!$album instanceof Album) {
            throw new NotFoundHttpException('Not found!');
        }

        $this->albumRepository->remove($album);
    }
}
