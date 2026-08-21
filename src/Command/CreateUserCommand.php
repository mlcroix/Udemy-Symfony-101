<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user by command',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher, 
        private EntityManagerInterface $entityManager) 
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->addArgument('email', InputArgument::REQUIRED, 'the email of the user')
        ->addArgument('password', InputArgument::REQUIRED, 'the password of the user')
        ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setRoles(["ROLE_USER"]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User created successfully!');
        return Command::SUCCESS;
    }
}
