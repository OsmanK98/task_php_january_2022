<?php

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\RegisterUserCommand;
use App\Application\CommandHandler\CommandHandlerInterface;
use App\Repository\UserRepository;
use App\Service\ValidatorObjectService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher,
                                private ValidatorObjectService      $validator,
                                private UserRepository              $userRepository)

    {
    }

    public function __invoke(RegisterUserCommand $command)
    {
        $user = new User();
        $user->setEmail($command->getEmail());
        $hashedPassword = $this->passwordHasher->hashPassword($user, $command->getPassword());
        $user->setPassword($hashedPassword);
        $this->validator->validate($user);
        $this->userRepository->add($user);
    }
}
