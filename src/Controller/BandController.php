<?php

namespace App\Controller;

use App\Application\Command\Band\CreateBandCommand;
use App\Application\Command\Band\DeleteBandCommand;
use App\Application\Command\Band\UpdateBandCommand;
use App\Application\Query\Band\ShowBandQuery;
use App\Service\HandlerExceptionService;
use App\Service\ValidatorObjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class BandController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private MessageBusInterface $queryBus,
        private SerializerInterface $serializer,
        private ValidatorObjectService $validator
    ) {
    }

    #[Route('/bands', name: 'create_band', methods: 'POST')]
    public function create(Request $request): Response
    {
        $name = $request->get('name');
        try {
            $createBandCommand = new CreateBandCommand($name);
            $this->validator->validate($createBandCommand);
            $this->commandBus->dispatch($createBandCommand);

            return new Response(null, Response::HTTP_CREATED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/bands/{id}', name: 'show_band', methods: 'GET')]
    public function show(int $id): Response
    {
        try {
            $showBandQuery = new ShowBandQuery($id);
            $this->validator->validate($showBandQuery);
            $queryResult = $this->queryBus->dispatch($showBandQuery);
            $handledStamp = $queryResult->last(HandledStamp::class)->getResult();
            $bandJson = $this->serializer->serialize(
                $handledStamp,
                'json',
                ['groups' => ['band:output']]
            );

            return new Response($bandJson, Response::HTTP_OK);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/bands/{id}', name: 'update_band', methods: 'PUT')]
    public function update(int $id, Request $request): Response
    {
        $name = $request->get('name');

        try {
            $updateBandCommand = new UpdateBandCommand($id, $name);
            $this->validator->validate($updateBandCommand);
            $this->commandBus->dispatch($updateBandCommand);

            return new Response(null, Response::HTTP_ACCEPTED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/bands/{id}', name: 'delete_band', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        try {
            $deleteBandCommand = new DeleteBandCommand($id);
            $this->validator->validate($deleteBandCommand);
            $this->commandBus->dispatch($deleteBandCommand);

            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }
}
