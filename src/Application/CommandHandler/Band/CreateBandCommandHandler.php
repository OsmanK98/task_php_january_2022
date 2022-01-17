<?php

namespace App\Application\CommandHandler\Band;

use App\Application\Command\Band\CreateBandCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;
use App\Service\ValidatorObjectService;

class CreateBandCommandHandler implements CommandHandlerInterface
{
    public function __construct(private BandRepository $bandRepository,
                                private ValidatorObjectService $validator)
    {

    }

    public function __invoke(CreateBandCommand $command){
        $band = new Band($command->getName());
        $this->validator->validate($band);
        $this->bandRepository->add($band);
    }
}
