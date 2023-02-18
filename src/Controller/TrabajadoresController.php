<?php

namespace App\Controller;

use App\Repository\EntityTrabajadoresRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\EntityTrabajadores;

#[Route(path: '/api')]
class TrabajadoresController extends AbstractController
{
    private $trabajadorRepository;

    public function __construct(EntityTrabajadoresRepository $trabajadorRepository)
    {
        $this->trabajadorRepository = $trabajadorRepository;
    }


    #[Route('/trabajadores/add', name: 'addTrabajador', methods: ['POST'])]
    public function addTrabajador(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $infoTra = new EntityTrabajadores;

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $infoTra->setNombre($data['nombre']);
        }
        if (isset($data['apellido'])) {
            $infoTra->setApellidos($data['apellido']);
        }
        if (isset($data['puesto_trabajo'])) {
            $infoTra->setPuestoTrabajo($data['puesto_trabajo']);
        }
        if (isset($data['horario'])) {
            $infoTra->setHorario($data['horario']);
        }
        if (isset($data['grupo'])) {
            $infoTra->setGrupo($data['grupo']);
        }

        $em->persist($infoTra);
        $em->flush();
        return $this->json(['message' => 'Trabajador creado correctamente']);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/trabajadores/{id}', name: 'getTrabajadorbyId', methods: ['GET'])]
    public function getTrabajadorbyId(ManagerRegistry $doctrine, int $id): Response
    {
        $infoTra = $doctrine->getRepository(EntityTrabajadores::class)->find($id);
        if (!$infoTra) {
            return $this->json(['message' => 'Trabajador no encontrado'], 404);
        } else {
        }
        $data = [];

        $data = [
            'id' => $infoTra->getId(),
            'nombre' => $infoTra->getNombre(),
            'apellido' => $infoTra->getApellidos(),
            'puesto_trabajo' => $infoTra->getPuestoTrabajo(),
            'horario' => $infoTra->getHorario(),
            'grupo' => $infoTra->getGrupo()
        ];
        return $this->json($data);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/trabajadores/put/{id}', name: 'putTrabajador', methods: ['PUT'])]
    public function putTrabajador(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $em = $doctrine->getManager();
        $trabajador = $doctrine->getRepository(EntityTrabajadores::class)->find($id);

        if (!$trabajador) {
            return $this->json(['message' => 'Trabajador no encontrado'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $trabajador->setNombre($data['nombre']);
        }
        if (isset($data['apellido'])) {
            $trabajador->setApellidos($data['apellido']);
        }
        if (isset($data['puesto_trabajo'])) {
            $trabajador->setPuestoTrabajo($data['puesto_trabajo']);
        }
        if (isset($data['horario'])) {
            $trabajador->setHorario($data['horario']);
        }
        if (isset($data['grupo'])) {
            $trabajador->setGrupo($data['grupo']);
        }

        $em->persist($trabajador);
        $em->flush();

        return $this->json(['message' => 'Trabajador actualizado correctamente']);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/trabajadores/del/{id}', name: 'delTrabajador', methods: ['DELETE'])]
    public function delTrabajadorbyId(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $infoTra = $doctrine->getRepository(EntityTrabajadores::class)->find($id);

        $em->remove($infoTra);
        $em->flush();
        return $this->json(['message' => 'Trabajador eliminado correctamente con numero de id: ' . $id]);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/trabajadores', name: 'getAllTrabajadores', methods: ['GET'])]
    public function getAllTrabajadores(ManagerRegistry $doctrine): Response
    {
        $trabajadores = $doctrine->getRepository(EntityTrabajadores::class)->findAll();
        if (!$trabajadores) {
            return $this->json(['message' => 'Trabajadores no encontrados'], 404);
        } else {
            $data = [];
            foreach ($trabajadores as $trabajador) {
                $data[] = [
                    'id' => $trabajador->getId(),
                    'nombre' => $trabajador->getNombre(),
                    'apellido' => $trabajador->getApellidos(),
                    'puesto_trabajo' => $trabajador->getPuestoTrabajo(),
                    'horario' => $trabajador->getHorario(),
                    'grupo' => $trabajador->getGrupo()
                ];
            }
        }
        return $this->json($data);
    }
}
