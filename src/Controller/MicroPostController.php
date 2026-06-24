<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\MicroPostType;

final class MicroPostController extends AbstractController
{
    private EntityManagerInterface $entityManagerInterface; 

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManagerInterface = $entityManager;
    }

    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $repository): Response
    {
        $microPosts = $repository->findAll();

        // $microPost1 = new MicroPost();
        // $microPost1->setTitle("Welcome to Poland");
        // $microPost1->setText("meep moop");
        // $microPost1->setCreated(new DateTime());

        // $this->entityManagerInterface->persist($microPost1);
        // $this->entityManagerInterface->flush();

        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
            'posts' => $microPosts

        ]);
    }

    #[Route('/micro-post/add', name: "app_micro_post_add")]
    public function add(Request $request): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $microPost->setCreated(new DateTime());
            
            $this->entityManagerInterface->persist($microPost);
            $this->entityManagerInterface->flush();
            
            $this->addFlash('success', 'Post created successfully!');
            
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/add.html.twig',
            [
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
