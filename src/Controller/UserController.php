<?php
// src/Controller/UserController.php

namespace App\Controller;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{


    public function __construct(
        private UserRepository $userRepository,
        private UserFactory $userFactory
    ) { }

    #[Route('/user', name: 'user')]
    public function List(): Response
    {
       // Utiliser la méthode findAll() pour récupérer tous les utilisateurs
        $users = $this->userRepository->findAll();
       
        // Passer les utilisateurs à la vue
        return $this->render('user/index.html.twig', [
          //  'controller_name' => 'UserController',
           'users' => $users,
        ]);
    }

    #[Route('/user/remove/{id}', name:'user-remove', methods: ["GET"])]
    public function RemoveUser(Request $request, EntityManagerInterface $entityManager, int $id): Response {
        $user = $this->userRepository->findOneBy(["id"=>$id]);
        
        if (!$user) {
            return $this->json(["message"=>"User not found"], 404);
        }

        $entityManager->remove( $user );
        $entityManager->flush();

        return $this->redirect("/user");
    }

    #[Route('/user/add', name: 'user-add', methods: ["POST"])]
    public function AddUser(Request $request, EntityManagerInterface $entityManager): Response {
        $nom = $request->request->getAlnum('last-name');
        $prenom = $request->request->getAlnum('first-name');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // Vérifier si tous les champs sont non nulles
        if (!$nom || !$prenom || !$email || !$password) {
            return $this->json([
                "message" => "Invalid input"
            ], 400);
        }
        
        // Doit être un email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                "message" => "Invalid email format"
            ], 400);
        }

        // Créer
        $user = $this->userFactory->create([
            "nom"=>$nom,
            "prenom"=>$prenom,
            "email"=>$email,
            "password"=>password_hash($password, PASSWORD_DEFAULT)
        ])->_real();

        // Ecrire
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirect("/user");
    }
}

