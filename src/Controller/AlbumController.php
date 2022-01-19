<?php

namespace App\Controller;

use App\Application\Command\Album\CreateAlbumCommand;
use App\Application\Command\Album\DeleteAlbumCommand;
use App\Application\Command\Album\UpdateAlbumCommand;
use App\Application\Query\Album\ListAlbumsQuery;
use App\Application\Query\Album\ShowAlbumQuery;
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
class AlbumController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private MessageBusInterface $queryBus,
        private SerializerInterface $serializer,
        private ValidatorObjectService $validator
    ) {
    }

    #[Route('/albums', name: 'create_album', methods: 'POST')]
    public function create(Request $request): Response
    {
        $requestData = $request->request->all();
        $title = $requestData['title'] ?? null;
        $cover = $request->files->get('cover') ?? null;
        $year = $requestData['year'] ?? null;
        $isPromoted = $requestData['is_promoted'] ?? null;
        $bandId = $requestData['band_id'] ?? null;

        try {
            $createAlbumCommand = new CreateAlbumCommand(
                $title,
                $cover,
                $year,
                $isPromoted,
                $bandId
            );
            $this->validator->validate($createAlbumCommand);
            $this->commandBus->dispatch($createAlbumCommand);

            return new Response(null, Response::HTTP_CREATED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/albums', name: 'list_albums', methods: 'GET')]
    public function list(): Response
    {
        try {
            $listAlbumsQuery = new ListAlbumsQuery();
            $this->validator->validate($listAlbumsQuery);
            $queryResult = $this->queryBus->dispatch($listAlbumsQuery);
            $handledStamp = $queryResult->last(HandledStamp::class)->getResult();
            $bandsJson = $this->serializer->serialize(
                $handledStamp,
                'json',
                ['groups' => ['album:output:collection']]
            );

            return new Response($bandsJson, Response::HTTP_OK);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/albums/{id}', name: 'show_album', methods: 'GET')]
    public function show(int $id): Response
    {
        try {
            $showAlbumQuery = new ShowAlbumQuery($id);
            $this->validator->validate($showAlbumQuery);
            $queryResult = $this->queryBus->dispatch($showAlbumQuery);
            $handledStamp = $queryResult->last(HandledStamp::class)->getResult();
            $albumJson = $this->serializer->serialize(
                $handledStamp,
                'json',
                ['groups' => ['album:output:item']]
            );

            return new Response($albumJson, Response::HTTP_OK);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/albums/{id}', name: 'update_album', methods: 'POST')]
    public function update(int $id, Request $request): Response
    {
        $requestData = $request->request->all();
        $title = $requestData['title'] ?? null;
        $cover = $request->files->get('cover') ?? null;
        $year = $requestData['year'] ?? null;
        $isPromoted = $requestData['is_promoted'] ?? null;
        $bandId = $requestData['band_id'] ?? null;

        try {
            $updateAlbumCommand = new UpdateAlbumCommand(
                $id,
                $title,
                $cover,
                $year,
                $isPromoted,
                $bandId
            );
            $this->validator->validate($updateAlbumCommand);
            $this->commandBus->dispatch($updateAlbumCommand);

            return new Response(null, Response::HTTP_ACCEPTED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/albums/{id}', name: 'delete_album', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        try {
            $deleteAlbumCommand = new DeleteAlbumCommand($id);
            $this->validator->validate($deleteAlbumCommand);
            $this->commandBus->dispatch($deleteAlbumCommand);

            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }
}
