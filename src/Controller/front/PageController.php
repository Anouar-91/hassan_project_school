<?php

namespace App\Controller\front;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\PostRepository;
use Symfony\Component\Mime\Address;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('front/home.html.twig', [
            'posts' => $postRepository->findBy([],["createdAt" => 'DESC']),
        ]);
    }
    /**
     * @Route("/annonce/{id}", name="app_post-detail")
     */
    public function postDetail($id, PostRepository $postRepo): Response
    {        
        $post = $postRepo->find($id);
        return $this->render('front/postDetail.html.twig', [
            'post' => $post,
        ]);
    }
  


}
