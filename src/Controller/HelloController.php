<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\UserProfile;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Repository\UserProfileRepository;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class HelloController extends AbstractController
{

    private EntityManagerInterface $entityManagerInterface; 

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManagerInterface = $entityManager;
    }

    #[Route('/', name: 'app_index')]
    public function index(MicroPostRepository $posts, CommentRepository $comments): Response
    {
        // $post = new MicroPost();
        // $post->setTitle("Welcome to Poland");
        // $post->setText("meep moop");
        // $post->setCreated(new \DateTime());

        // $comment1 = new Comment();
        // $comment1->setText("This is a comment");
        // $post->addComment($comment1);

        // $this->entityManagerInterface->persist($post);
        // $this->entityManagerInterface->flush();

        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => [],
                'limit' => 2
            ]
        );
        // $user = new User();
        // $user->setEmail("meepmoop@gmail.com");
        // $user->setPassword("meepmoop");
        // $profile = new UserProfile();
        // $profile->setUser($user);
        // $userProfileRepo->add($profile);
        
        // return $this->render(
        //     'hello/index.html.twig',
        //     [
        //         'messages' => $this->messages,
        //         'limit' => $limit
        //     ]
        // );
    }
}
