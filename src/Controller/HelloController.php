<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Bundle\SecurityBundle\Security;


class HelloController extends AbstractController
{
    #[Route('/', name: 'app_base')]
    public function accueil(): Response
    {

        return $this->render('index.html.twig', []);
    }


    #[Route('/hello', name: 'app_hello')]
    public function index(Security $security, UserRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $security->getUser();
        $nom = $user->getUserIdentifier();
        $utilisateur = $repo->findOneBy(['email' => $nom]);
        $VarName = $utilisateur->getName();
        $VarFirstName = $utilisateur->getFirstname();     

        return $this->render('hello/index.html.twig', [
            'controller_name' => $VarName,
            'controller_firstname' => $VarFirstName,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
