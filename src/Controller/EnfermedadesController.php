<?php

namespace App\Controller;

use App\Repository\EnfermedadesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Enfermedades; 

#[Route(path: '/api')]
class EnfermedadesController extends AbstractController
{
    private $enfermedadesRespository;

    public function __construct(EnfermedadesRepository $enfermedades)
    {
        $this->enfermedadesRespository = $enfermedades;
    }
    #[Route('/enfermedades/add', name: 'addEnfermedades', methods: ['POST'])]
    public function addEnfermedades(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $enf = new Enfermedades;

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $enf->setNombre($data['nombre']);
        }
        if (isset($data['descripcion'])) {
            $enf->setDescripcion($data['descripcion']);
        }

        $em->persist($enf);
        $em->flush();
        return $this->json(['message' => 'Enfermedad generada correctamente']);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/enfermedades/{id}', name: 'getEnfermedadbyId', methods: ['GET'])]
    public function getEnfermedadbyId(ManagerRegistry $doctrine, int $id): Response
    {
        $enf = $doctrine->getRepository(Enfermedades::class)->find($id);
        if (!$enf) {
            return $this->json(['message' => 'Enfermedad no encontrada'], 404);
        } else {
        }
        $data = [];

        $data = [
            'id' => $enf->getId(),
            'nombre' => $enf->getNombre(),            
            'descripcion' => $enf->getDescripcion(),
        ];
        return $this->json($data);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/enfermedades/put/{id}', name: 'putEnfermedadby', methods: ['PUT'])]
    public function putEnfermedadesby(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $em = $doctrine->getManager();
        $enf = $doctrine->getRepository(Enfermedades::class)->find($id);

        if (!$enf) {
            return $this->json(['message' => 'Enfermedad no encontrada'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $enf->setNombre($data['nombre']);
        }
        if (isset($data['desc'])) {
            $enf->setDescripcion($data['desc']);
        }

        $em->persist($enf);
        $em->flush();

        return $this->json(['message' => 'Enfermedad actualizado correctamente']);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/enfermedades/del/{id}', name: 'delEnfermedades', methods: ['DELETE'])]
    public function delEnfermedadesbyId(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $enfermedad = $doctrine->getRepository(Enfermedades::class)->find($id);

        $em->remove($enfermedad);
        $em->flush();
        return $this->json(['message' => 'Enfermedad eliminada correctamente con numero de id: ' . $id]);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/enfermedades', name: 'getAllenfermedades', methods: ['GET'])]
    public function getAllEnfermedades(ManagerRegistry $doctrine): Response
    {
        $res = $doctrine->getRepository(Enfermedades::class)->findAll();
        if (!$res) {
            return $this->json(['message' => 'Enfermedades no encontrados'], 404);
        } else {
            $data = [];
            foreach ($res as $e) {
                $data[] = [
                    'id' => $e->getId(),
                    'nombre' => $e->getNombre(),
                    'descripcion' => $e->getDescripcion()
                ];
            }
        }
        return $this->json($data);
    }
}
