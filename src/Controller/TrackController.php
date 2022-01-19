<?php

namespace App\Controller;

use App\Application\Command\Track\CreateTrackCommand;
use App\Application\Command\Track\DeleteTrackCommand;
use App\Application\Command\Track\UpdateTrackCommand;
use App\Application\Query\Track\ListTracksQuery;
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
class TrackController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private MessageBusInterface $queryBus,
        private SerializerInterface $serializer,
        private ValidatorObjectService $validator
    ) {
    }

    #[Route('/tracks', name: 'create_track', methods: 'POST')]
    public function create(Request $request): Response
    {
        $title = $request->get('title');
        $url = $request->get('url');
        $albumId = $request->get('album_id');

        try {
            $createTrackCommand = new CreateTrackCommand(
                $title,
                $url,
                $albumId
            );
            $this->validator->validate($createTrackCommand);
            $this->commandBus->dispatch($createTrackCommand);

            return new Response(null, Response::HTTP_CREATED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/tracks', name: 'list_tracks', methods: 'GET')]
    public function list(): Response
    {
        try {
            $listTracksQuery = new ListTracksQuery();
            $this->validator->validate($listTracksQuery);
            $queryResult = $this->queryBus->dispatch(new ListTracksQuery());
            $handledStamp = $queryResult->last(HandledStamp::class)->getResult();
            $tracksJson = $this->serializer->serialize(
                $handledStamp,
                'json',
                ['groups' => ['track:output']]
            );

            return new Response($tracksJson, Response::HTTP_OK);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/tracks/{id}', name: 'update_track', methods: 'PUT')]
    public function update(int $id, Request $request): Response
    {
        $title = $request->get('title');
        $url = $request->get('url');
        $albumId = $request->get('album_id');

        try {
            $updateTrackCommand = new UpdateTrackCommand(
                $id,
                $title,
                $url,
                $albumId
            );
            $this->validator->validate($updateTrackCommand);
            $this->commandBus->dispatch($updateTrackCommand);

            return new Response(null, Response::HTTP_ACCEPTED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/tracks/{id}', name: 'delete_track', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        try {
            $deleteTrackCommand = new DeleteTrackCommand($id);
            $this->validator->validate($deleteTrackCommand);
            $this->commandBus->dispatch($deleteTrackCommand);

            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }
}
