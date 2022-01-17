<?php

namespace App\Application\CommandHandler\Band;

use App\Application\Command\Band\DeleteBandCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteBandCommandHandler implements CommandHandlerInterface
{
    public function __construct(private BandRepository $bandRepository)
    {

    }

    public function __invoke(DeleteBandCommand $command)
    {
        $band = $this->bandRepository->findOneBy(['id' => $command->getBandId()]);

        if (!$band instanceof Band) {
            throw new NotFoundHttpException('Not found!');
        }

        $this->bandRepository->remove($band);
    }
}
