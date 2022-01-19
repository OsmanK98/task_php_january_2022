<?php

namespace App\Application\CommandHandler\Album;

use App\Application\Command\Album\UpdateAlbumCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Album;
use App\Entity\Band;
use App\Repository\AlbumRepository;
use App\Repository\BandRepository;
use App\Service\RemoveFileService;
use App\Service\UploadFileService;
use App\Service\ValidatorObjectService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateAlbumCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AlbumRepository $albumRepository,
        private BandRepository $bandRepository,
        private ValidatorObjectService $validator,
        private UploadFileService $uploadFileService,
        private RemoveFileService $removeFileSerivce
    ) {
    }

    public function __invoke(UpdateAlbumCommand $command)
    {
        $album = $this->albumRepository->findOneBy(['id' => $command->getAlbumId()]);

        if (!$album instanceof Album) {
            throw new NotFoundHttpException('Not found the album!');
        }

        $band = $this->bandRepository->findOneBy(['id' => $command->getBandId()]);

        if (!$band instanceof Band) {
            throw new NotFoundHttpException('Not found the band!');
        }

        $oldAlbumCover = $album->getCover();
        $newAlbumCover = $this->uploadFileService->save($command->getCover());
        $this->removeFileSerivce->remove($oldAlbumCover);

        $album->setBand($band);
        $album->setCover($newAlbumCover);
        $album->setIsPromoted($command->isPromoted());
        $album->setTitle($command->getTitle());
        $album->setYear($command->getYear());

        $this->validator->validate($album);
        $this->albumRepository->update($album);
    }
}
