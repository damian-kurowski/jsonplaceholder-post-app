<?php

namespace App\Command;

use App\Entity\AppUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Dodaje użytkownika do systemu.',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $emailQuestion = new Question('Email: ');
        $email = $helper->ask($input, $output, $emailQuestion);

        $passwordQuestion = new Question('Hasło: ');
        $passwordQuestion->setHidden(true);
        $plainPassword = $helper->ask($input, $output, $passwordQuestion);

        $user = new AppUser();
        $user->setEmail($email);
        $hashed = $this->hasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashed);
        $user->setRoles(['ROLE_USER']);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('<info>Użytkownik został dodany.</info>');
        return Command::SUCCESS;
    }
}
