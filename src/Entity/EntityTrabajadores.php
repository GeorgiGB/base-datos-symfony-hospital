<?php

namespace App\Entity;

use App\Repository\EntityTrabajadoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityTrabajadoresRepository::class)]
class EntityTrabajadores
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255)]
    private ?string $puestoTrabajo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $horario = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $grupo = '';

    #[ORM\OneToMany(mappedBy: 'atendidopor', targetEntity: EntityPacientes::class)]
    private Collection $entityPacientes;

    public function __construct()
    {
        $this->entityPacientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getPuestoTrabajo(): string
    {
        return $this->puestoTrabajo;
    }

    public function setPuestoTrabajo(string $puestoTrabajo): self
    {
        $this->puestoTrabajo = $puestoTrabajo;

        return $this;
    }

    public function getHorario(): string
    {
        return $this->horario;
    }

    public function setHorario(?string $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    public function getGrupo(): string
    {
        return $this->grupo;
    }

    public function setGrupo(?string $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * @return Collection<int, EntityPacientes>
     */
    public function getEntityPacientes(): Collection
    {
        return $this->entityPacientes;
    }

    public function addEntityPaciente(EntityPacientes $entityPaciente): self
    {
        if (!$this->entityPacientes->contains($entityPaciente)) {
            $this->entityPacientes->add($entityPaciente);
            $entityPaciente->setAtendidopor($this);
        }

        return $this;
    }

    public function removeEntityPaciente(EntityPacientes $entityPaciente): self
    {
        if ($this->entityPacientes->removeElement($entityPaciente)) {
            // set the owning side to null (unless already changed)
            if ($entityPaciente->getAtendidopor() === $this) {
                $entityPaciente->setAtendidopor(null);
            }
        }

        return $this;
    }
}
