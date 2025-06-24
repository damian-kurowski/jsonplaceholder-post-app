<?php

namespace App\Command;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:fetch-posts',
    description: 'Pobiera posty i użytkowników z API i zapisuje je do lokalnej bazy danych.',
)]
class FetchPostsCommand extends Command
{
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Rozpoczynam pobieranie danych z API...</info>');

        $usersResponse = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $usersData = $usersResponse->toArray();

        $userRepo = $this->em->getRepository(User::class);

        foreach ($usersData as $userData) {
            $existingUser = $userRepo->findOneBy(['externalId' => $userData['id']]);

            if (!$existingUser) {
                $user = new User();
                $user->setExternalId($userData['id']);
                $user->setName($userData['name']);
                $this->em->persist($user);
            }
        }

        $this->em->flush();
        $output->writeln('<info>Użytkownicy pobrani i zapisani.</info>');

        $postsResponse = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
        $postsData = $postsResponse->toArray();

        $postRepo = $this->em->getRepository(Post::class);

        foreach ($postsData as $postData) {
            $existingPost = $postRepo->findOneBy(['externalId' => $postData['id']]);

            if (!$existingPost) {
                $user = $userRepo->findOneBy(['externalId' => $postData['userId']]);

                if ($user) {
                    $post = new Post();
                    $post->setExternalId($postData['id']);
                    $post->setTitle($postData['title']);
                    $post->setBody($postData['body']);
                    $post->setAuthor($user);
                    $this->em->persist($post);
                }
            }
        }

        $this->em->flush();
        $output->writeln('<info>Posty pobrane i zapisane.</info>');

        return Command::SUCCESS;
    }
}
