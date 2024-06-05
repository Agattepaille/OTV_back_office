<?php

namespace App\Controller;

use App\Entity\User;
use App\DTO\UserRequest;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use App\Form\ChangeUserPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profil')]
class ProfileController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_profile_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('home');
        }

        return $this->render('profile/index.html.twig', [
            'user' => $currentUser,
        ]);
    }


    #[Route('/{id}', name: 'app_profile_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('home');
        }

        return $this->render('profile/show.html.twig', [
            'user' => $currentUser,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $currentUser = $this->getUser();

        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser) {
            $this->addFlash('error',  'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('home');
        }

        //Si l'utilisateur veut modifier un autre profil que le sien à l'aide d'un ID dans l'url, redirection vers profil.
        if ($currentUser !== $user) {
            return $this->redirectToRoute('app_profile_show', ['id' => $currentUser], Response::HTTP_SEE_OTHER);
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

            $entityManager->flush();

            return $this->redirectToRoute('app_otv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/editPassword', name: 'app_profile_editPassword', methods: ['GET', 'POST'])]
    public function editPassword(LoggerInterface $logger, User $user, Security $security, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(ChangeUserPasswordFormType::class);

        $form->handleRequest($request);

        $currentUser = $security->getUser();
        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_home');
        }

        //Si l'utilisateur veut modifier un autre profil que le sien à l'aide d'un ID dans l'url, redirection vers profil.
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_profile_show ', ['id' => $currentUser], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['currentPassword'])) {
                $newPassword = $form->get('newPassword')->getData();        

                $logger->info('Password  ' . $newPassword);

                $user->setPassword(
                    $hasher->hashPassword(
                        $user,$newPassword
                    )
                );

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été modifié'
                );
                return $this->redirectToRoute('app_otv_index');
            } else {
                $this->addFlash(
                    'warning',
                    'Mot de passe incorrect'
                );
            }
        }
        return $this->render('profile/editPassword.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    }
}
