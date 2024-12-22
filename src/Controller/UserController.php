<?php

namespace App\Controller;

use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Form\UpdateUserForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profile', name: 'app_user_profile')]
    public function profile(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/user/update', name: 'app_user_update')]
    public function update(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($user = $this->getUser()) {
//            if ($user instanceof HealthProfessional) {
//                $this->addFlash('error', 'Votre compte peut seulement être mis à jour par un administrateur.');
//                return $this->redirectToRoute('app_home');
//            }
            $form = $this->createForm(UpdateUserForm::class, $user);
            $form->handleRequest($request);
            $user = $this->getUser();
            $originalUser = clone $user;
            if ($form->isSubmitted() && $form->isValid()) {
                if ($form->get('password')->getData()) {
                    $user->setPassword(
                        $userPasswordHasher->hashPassword($user, $form->get('password')->getData())
                    );
                } else {
                    $user->setPassword(
                        $userPasswordHasher->hashPassword($user, $originalUser->getPassword())
                    );
                }

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Les informations de l\'utilisateur ont été mises à jour.');
            }

            return $this->redirectToRoute('app_user_update');
        }
        $this->addFlash('error', 'Vous devez vous connecter pour modifier votre compte.');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/user/delete', name: 'app_user_delete', requirements: ['id' => '\d+'])]
    public function delete(Request $request, EntityManagerInterface $entityManager)
    {
        if (!$user = $this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class, [
                'label' => 'Supprimer',
                'attr' => ['class' => 'btn btn-danger'],
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                'attr' => ['class' => 'btn btn-secondary'],
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('delete')->isClicked()) {
                if ($user instanceof Patient) {
                    foreach ($user->getConsultation() as $consultation) {
                        $entityManager->remove($consultation);
                    }
                }
                if ($user instanceof HealthProfessional) {
                    $this->addFlash('error', 'Votre compte peut seulement être supprimé par un administrateur.');

                    return $this->redirectToRoute('app_home');
                }
                $entityManager->remove($user);
                $entityManager->flush();

                $this->addFlash('success', 'Utilisateur supprimé avec succès.');

                $request->getSession()->invalidate();
                $this->container->get('security.token_storage')->setToken(null);

                return $this->redirectToRoute('app_home');
            }

            if ($form->get('cancel')->isClicked()) {
                $this->addFlash('info', 'Suppression annulée.');

                return $this->redirectToRoute('app_home', []);
            }
        }

        return $this->render('user/delete.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
