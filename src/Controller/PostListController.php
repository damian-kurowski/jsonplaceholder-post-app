<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostListController extends AbstractController
{
    #[Route('/lista', name: 'post_list')]
    public function index(PostRepository $postRepo): Response
    {
        return $this->render('post_list/index.html.twig', [
            'posts' => $postRepo->findAll(),
        ]);
    }

    #[Route('/lista/delete/{id}', name: 'post_delete')]
    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('post_list');
    }

}
