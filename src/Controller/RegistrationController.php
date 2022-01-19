<?php

namespace App\Controller;

use App\Application\Command\User\RegisterUserCommand;
use App\Service\HandlerExceptionService;
use App\Service\ValidatorObjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class RegistrationController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private ValidatorObjectService $validator
    ) {
    }

    #[Route('/registration', name: 'registration', methods: 'POST')]
    public function register(Request $request): Response
    {
        $email = $request->get('username');
        $password = $request->get('password');

        try {
            $registerUserCommand = new RegisterUserCommand(
                $email,
                $password
            );
            $this->validator->validate($registerUserCommand);
            $this->commandBus->dispatch($registerUserCommand);

            return new Response(null, Response::HTTP_CREATED);
        } catch (HandlerFailedException | \Exception $e) {
            $message = HandlerExceptionService::getMessage($e);
            return new Response($message, Response::HTTP_BAD_REQUEST);
        }
    }
}
