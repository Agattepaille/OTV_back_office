<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\DTO\UserRequest;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $userRequest = new UserRequest();
        $form = $this->createForm(UserFormType::class, $userRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setEmail($form->get('email')->getData());
            $user->setLastname($form->get('lastname')->getData());
            $user->setFirstname($form->get('firstname')->getData());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $currentUser = $this->getUser();

        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser->getRoles() === ['ROLE_ADMIN']) {
            $this->addFlash('error',  'Vous devez être admin pour accéder à cette page');
            return $this->redirectToRoute('app_home');
        }

        $userRequest = new UserRequest();
        $userRequest->setEmail($user->getEmail());
        $userRequest->setLastname($user->getLastname());
        $userRequest->setFirstname($user->getFirstname());

        $form = $this->createForm(UserFormType::class, $userRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRequest = $form->getData();

            $user->setEmail($userRequest->getEmail());
            $user->setLastname($userRequest->getLastname());
            $user->setFirstname($userRequest->getFirstname());
            if (!empty($userRequest->getNewPassword())) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $userRequest->getNewPassword()
                    )
                );
            } else {
                $user->setPassword($userRequest->getOldPassword());
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
