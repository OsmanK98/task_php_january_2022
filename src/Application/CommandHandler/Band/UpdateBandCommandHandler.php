<?php

namespace App\Application\CommandHandler\Band;

use App\Application\Command\Band\UpdateBandCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;
use App\Service\ValidatorObjectService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateBandCommandHandler implements CommandHandlerInterface
{
    public function __construct(private BandRepository         $bandRepository,
                                private ValidatorObjectService $validator)
    {

    }

    public function __invoke(UpdateBandCommand $command)
    {
        $band = $this->bandRepository->findOneBy(['id' => $command->getBandId()]);

        if (!$band instanceof Band) {
            throw new NotFoundHttpException('Not found!');
        }

        $band->setName($command->getName());
        $this->validator->validate($band);
        $this->bandRepository->update($band);
    }
}
