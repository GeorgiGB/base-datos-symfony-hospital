<?php

namespace App\Entity;

use App\Repository\EntityPacientesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityPacientesRepository::class)]
class EntityPacientes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellidos = null;

    #[ORM\Column]
    private ?int $numCarnet = null;

    #[ORM\Column(nullable: true)]
    private ?int $idEnfermedad = null;

    #[ORM\ManyToOne(inversedBy: 'entityPacientes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EntityTrabajadores $atendidopor = null;

    #[ORM\ManyToMany(targetEntity: Enfermedades::class, inversedBy: 'entityPacientes')]
    private Collection $enfermedad;

    public function __construct()
    {
        $this->enfermedad = new ArrayCollection();
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

    public function setApellidos(?string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getNumCarnet(): ?int
    {
        return $this->numCarnet;
    }

    public function setNumCarnet(int $numCarnet): self
    {
        $this->numCarnet = $numCarnet;

        return $this;
    }

    public function getIdEnfermedad(): ?int
    {
        return $this->idEnfermedad;
    }

    public function setIdEnfermedad(?int $idEnfermedad): self
    {
        $this->idEnfermedad = $idEnfermedad;

        return $this;
    }

    public function getAtendidopor(): ?EntityTrabajadores
    {
        return $this->atendidopor;
    }

    public function setAtendidopor(?EntityTrabajadores $atendidopor): self
    {
        $this->atendidopor = $atendidopor;

        return $this;
    }

    /**
     * @return Collection<int, Enfermedades>
     */
    public function getEnfermedad(): Collection
    {
        return $this->enfermedad;
    }

    public function addEnfermedad(Enfermedades $enfermedad): self
    {
        if (!$this->enfermedad->contains($enfermedad)) {
            $this->enfermedad->add($enfermedad);
        }

        return $this;
    }

    public function removeEnfermedad(Enfermedades $enfermedad): self
    {
        $this->enfermedad->removeElement($enfermedad);

        return $this;
    }
}
