<?php

namespace App\Controller;

use App\Repository\EntityPacientesRepository;
use App\Entity\EntityPacientes;
use App\Entity\EntityTrabajadores;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class PacientesController extends AbstractController
{
    private $pacienteRepository;

    public function __construct(EntityPacientesRepository $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }


    #[Route('/pacientes/add', name: 'addPaciente', methods: ['POST'])]
    public function addPaciente(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $paciente = new EntityPacientes();
        $trabajador = new EntityTrabajadores();

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $paciente->setNombre($data['nombre']);
        }
        if (isset($data['apellidos'])) {
            $paciente->setApellidos($data['apellidos']);
        }
        if (isset($data['numCarnet'])) {
            $paciente->setNumCarnet($data['numCarnet']);
        }
        if (isset($data['atendido'])) {
            $trabajador = $em->getRepository(EntityTrabajadores::class)->find($data['atendido']);
            if ($trabajador) {
                $paciente->setAtendidopor($data['atendido']);
            } else {
                return $this->json(['message' => 'No se le ha pasado un trabajador correctamente']);
            }
        }
        if (isset($data['idEnfermedad'])) {
            $paciente->setIdEnfermedad($data['idEnfermedad']);
        }

        $em->persist($paciente);
        $em->flush();
        return $this->json(['message' => 'Paciente generado correctamente']);
    }
    //------------------------------------------------------------------------------------//
        #[Route('/pacientes/{id}', name: 'getPacientebyId', methods: ['GET'])]
        public function getPacientebyId(ManagerRegistry $doctrine, int $id): Response
        {   
            $paciente = $doctrine->getRepository(EntityPacientes::class)->find($id);
            $trabajador = $doctrine->getRepository(EntityTrabajadores::class);
            if (!$paciente) {
                return $this->json(['message' => 'Paciente no encontrado'], 404);
            } else {
            }
            $data = [];
            
            $data = [
                'id' => $paciente->getId(),
                'num_carnet' => $paciente->getNumCarnet(),
                'nombre' => $paciente->getNombre(),
                'apellido' => $paciente->getApellidos(),
                'atendido_por' => $paciente->getAtendidopor()->getNombre(),
                'id_enfermedad' => $paciente->getIdEnfermedad()
            ];
            return $this->json($data);
        }
    //------------------------------------------------------------------------------------//
    #[Route('/pacientes/put/{id}', name: 'putPacienteby', methods: ['PUT'])]
    public function putPacienteby(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $em = $doctrine->getManager();
        $paciente = $doctrine->getRepository(Entitypacientes::class)->find($id);

        if (!$paciente) {
            return $this->json(['message' => 'Paciente no encontrado'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $paciente->setNombre($data['nombre']);
        }
        if (isset($data['apellidos'])) {
            $paciente->setApellidos($data['apellidos']);
        }
        if (isset($data['atendido'])) {
            $trabajador = $em->getRepository(EntityTrabajadores::class)->find($data['atendido']);
            if ($trabajador) {
                $paciente->setAtendidopor($trabajador);
            } else {
                return $this->json(['message' => 'No se le ha pasado un trabajador correctamente']);
            }
        }
        if (isset($data['numCarnet'])) {
            $paciente->setNumCarnet($data['numCarnet']);
        }   
        if (isset($data['idEnfermedad'])) {
            $paciente->setIdEnfermedad($data['idEnfermedad']);
        }

        $em->persist($paciente);
        $em->flush();

        return $this->json(['message' => 'Paciente actualizado correctamente']);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/pacientes/del/{id}', name: 'delPaciente', methods: ['DELETE'])]
    public function delPacientebyId(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $paciente = $doctrine->getRepository(Entitypacientes::class)->find($id);

        $em->remove($paciente);
        $em->flush();
        return $this->json(['message' => 'Paciente eliminado correctamente con numero de id: ' . $id]);
    }
    //------------------------------------------------------------------------------------//
    #[Route('/pacientes', name: 'getAllpacientes', methods: ['GET'])]
    public function getAllpacientes(ManagerRegistry $doctrine)
    {   
        $paciente = $doctrine->getRepository(EntityPacientes::class)->findAll();
        if (!$paciente) {
            return $this->json(['message' => 'Paciente no encontrado'], 404);
        } else {
        }
        $data = [];

        foreach ($paciente as $e) {
            $atendido_por = $e->getAtendidopor();
            $atendido_por_data = $atendido_por->getNombre();
                     $data[] = [
                         'id' => $e->getId(),
                         'num_carnet' => $e->getNumCarnet(),
                         'nombre' => $e->getNombre(),
                         'apellido' => $e->getApellidos(),
                         'atendido_por' => $atendido_por_data,
                         'id_enfermedad' => $e->getIdEnfermedad()
                     ];
                 }
        return $this->json($data);
    }
}
