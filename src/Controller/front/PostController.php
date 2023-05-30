<?php

namespace App\Controller\front;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/mes-annonces")
 */
class PostController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $manager){
        $this->manager = $manager;
    }


    /**
     * @Route("/", name="app_post-search", methods="GET")
     */
    public function search(PostRepository $postRepository): Response
    {

        return $this->render('front/post/search.html.twig', [
            'posts' => $postRepository->findAll(), 
        ]);
    }

        /**
     * @Route("/create", name="app_post-create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $post = new Post();
        $em = $this->manager->getManager();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('app_post-search');
        }

        return $this->render('front/post/create.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }





}
