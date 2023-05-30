<?php

namespace App\Controller\front;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\Mime\Address;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{

    private $manager;
    public function __construct(ManagerRegistry $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @Route("/inscription", name="registration", methods="GET|POST")
     */
    public function register(Request $request,  UserPasswordHasherInterface $encoder, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $formRegister = $this->createForm(RegistrationType::class, $user);
        $formRegister->handleRequest($request);
        // dd($formRegister);
        if ($formRegister->isSubmitted() && $formRegister->isValid()) {
            $em = $this->manager->getManager();
            $user->setRoles(["ROLE_USER"]);
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $firstname = ucfirst($user->getFirstname());
            $user->setFirstname($firstname);
            $lastname = strtoupper($user->getLastname());
            $user->setLastname($lastname);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Merci pour votre inscription ! Vous pouvez désormais vous connecter.');
            return $this->redirectToRoute('registration');
        }

        return $this->render('security/security.html.twig', [
            'formRegister' => $formRegister->createView(),
        ]);
    }
}
