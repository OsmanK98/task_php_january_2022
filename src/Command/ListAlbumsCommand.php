<?php

namespace App\Command;

use Doctrine\Common\Util\Debug;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

#[AsCommand(
    name: 'list-albums',
    description: 'Add a short description for your command',
)]
class ListAlbumsCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $httpClient = HttpClient::create();

        $loginCheck = $httpClient->request('GET', 'http://127.0.0.1:8080/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'username' => $input->getArgument('username'),
                'password' => $input->getArgument('password'),
            ])
        ]);

        $responseData = json_decode($loginCheck->getContent());

        $response = $httpClient->request('GET', 'http://127.0.0.1:8080/api/albums', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $responseData->token
            ]
        ]);

        dump(json_decode($response->getContent(), true));
        return Command::SUCCESS;
    }
}
