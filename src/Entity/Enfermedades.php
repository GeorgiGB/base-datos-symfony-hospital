<?php

namespace App\Entity;

use App\Repository\EnfermedadesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnfermedadesRepository::class)]
class Enfermedades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\ManyToMany(targetEntity: EntityPacientes::class, mappedBy: 'enfermedad')]
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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
            $entityPaciente->addEnfermedad($this);
        }

        return $this;
    }

    public function removeEntityPaciente(EntityPacientes $entityPaciente): self
    {
        if ($this->entityPacientes->removeElement($entityPaciente)) {
            $entityPaciente->removeEnfermedad($this);
        }

        return $this;
    }
}
