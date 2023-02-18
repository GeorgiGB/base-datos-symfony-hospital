<?php

namespace App\Controller;

use App\Entity\Usuarios;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route(path: '/user')]
class UserController extends AbstractController{


    #[Route('/register', name: 'new_contact_api', methods: ['POST'])]
    public function apiRegister(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Usuarios();
        $content=$request->getContent();
        $user->fromJson($content);
        $user->setPassword(
            $userPasswordHasher->hashPassword(
            $user,
            $user->getPassword()
            )
        );

        $numUsers=$entityManager->getRepository(Usuarios::class)
            ->createQueryBuilder('user')
            ->select('count(user.id)')
            ->getQuery()
            ->getSingleScalarResult();
        if($numUsers < 1) {
            $user->setRoles(['ROLE_ADMIN']);
        }
        $entityManager->persist($user);
        $entityManager->flush();
        $response = [
            'ok' => true,
            'msg' => "Usuario agregado",
            ];
        return new JsonResponse($response);
    }

    #[Route('/register/delete/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(EntityManagerInterface $entityManager,int $id): Response
    {
        $user = $entityManager->getRepository(Usuarios::class)->find($id);

        if (!$user) {
            $response = [
                'ok' => false,
                'msg' => "Usuario no encontrado",
            ];
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $response = [
            'ok' => true,
            'message' => "Usuario eliminado",
        ];
        return new JsonResponse($response);
    }

    
}
