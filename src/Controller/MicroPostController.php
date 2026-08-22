<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\Comment;
use App\Repository\MicroPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\MicroPostType;
use App\Form\CommentType;

final class MicroPostController extends AbstractController
{
    private EntityManagerInterface $entityManagerInterface; 

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManagerInterface = $entityManager;
    }

    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $repository): Response
    {
        $microPosts = $repository->findAllWithComments();

        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
            'posts' => $microPosts

        ]);
    }

    #[Route('/micro-post/{post}/edit', name: "app_micro_post_edit")]
    public function edit(MicroPost $post, Request $request): Response
    {
        $form = $this->createForm(MicroPostType::class, $post);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreated(new DateTime());
            $this->entityManagerInterface->persist($post);
            $this->entityManagerInterface->flush();
            
            $this->addFlash('success', 'Post edited successfully!');
            
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/add.html.twig',
            [
                'page_title' => "Edit post",
                'bread' => "-> Edit Post",
                'post' => $post,
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/micro-post/add', name: "app_micro_post_add")]
    public function add(Request $request): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $microPost->setCreated(new DateTime());
            $microPost->setAuthor($this->getUser());
            $this->entityManagerInterface->persist($microPost);
            $this->entityManagerInterface->flush();
            
            $this->addFlash('success', 'Post created successfully!');
            
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/add.html.twig',
            [
                'page_title' => "Create post",
                'bread' => " -> Add Post",
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/micro-post/{post}/comment', name: "app_micro_post_comment")]
    public function comment(MicroPost $post, Request $request): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $this->entityManagerInterface->persist($comment);
            $this->entityManagerInterface->flush();
            
            $this->addFlash('success', 'Comment posted successfully!');
            
            return $this->redirectToRoute(
                'app_micro_post_show',
                ['post' => $post->getId()]
            );
        }

        return $this->render('micro_post/comment.html.twig',
            [
                'page_title' => "Add comment",
                'bread' => " -> Add comment",
                'post' => $post,
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/micro-post/{post}', name: "app_micro_post_show")]
    public function show(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post
        ]);
    }
}
