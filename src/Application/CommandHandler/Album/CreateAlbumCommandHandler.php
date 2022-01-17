<?php

namespace App\Application\CommandHandler\Album;

use App\Application\Command\Album\CreateAlbumCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Album;
use App\Entity\Band;
use App\Repository\AlbumRepository;
use App\Repository\BandRepository;
use App\Service\MailerService;
use App\Service\UploadFileService;
use App\Service\ValidatorObjectService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateAlbumCommandHandler implements CommandHandlerInterface
{
    public function __construct(private AlbumRepository        $albumRepository,
                                private BandRepository         $bandRepository,
                                private UploadFileService      $uploadFileService,
                                private ValidatorObjectService $validator,
                                private MailerService          $mailerService,
                                private ContainerInterface     $container)
    {

    }

    public function __invoke(CreateAlbumCommand $command)
    {
        $band = $this->bandRepository->findOneBy(['id' => $command->getBandId()]);

        if (!$band instanceof Band) {
            throw new NotFoundHttpException('Not found the band!');
        }

        $coverFileName = $this->uploadFileService->save($command->getCover());
        $album = new Album(
            $command->getTitle(),
            $coverFileName,
            $command->getYear(),
            $command->isPromoted(),
            $band
        );

        $this->validator->validate($album);
        $this->albumRepository->add($album);

        if ($album->getIsPromoted()) {
            $this->mailerService->send(
                'New album created!',
                'New album ' . $album->getTitle() . ' was created in our system!',
                [$this->container->getParameter('receiver_email')]
            );
        }
    }
}
