<?php

namespace App\Entity;

use App\Repository\TorneoGeneroCategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TorneoGeneroCategoriaRepository::class)]
#[UniqueEntity(fields:['genero', 'categoria'])]
class TorneoGeneroCategoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'torneoGeneroCategorias')]
    private ?Torneo $torneo = null;

    #[ORM\ManyToOne(inversedBy: 'torneoGeneroCategorias')]
    private ?Genero $genero = null;

    #[ORM\ManyToOne(inversedBy: 'torneoGeneroCategorias')]
    private ?Categoria $categoria = null;

    #[ORM\OneToMany(mappedBy: 'torneoGeneroCategoria', targetEntity: Equipo::class)]
    private Collection $equipos;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'torneoGeneroCategoria', targetEntity: Zona::class)]
    private Collection $zonas;

    #[ORM\Column]
    private ?bool $cerrado = false;

    #[ORM\Column]
    private ?bool $creado = false;

    #[ORM\OneToMany(mappedBy: 'torneoGeneroCategoria', targetEntity: PlayOff::class)]
    private Collection $playOffs;

    public function __construct()
    {
        $this->equipos = new ArrayCollection();
        $this->zonas = new ArrayCollection();
        $this->playOffs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTorneo(): ?Torneo
    {
        return $this->torneo;
    }

    public function setTorneo(?Torneo $torneo): static
    {
        $this->torneo = $torneo;

        return $this;
    }

    public function getGenero(): ?Genero
    {
        return $this->genero;
    }

    public function setGenero(?Genero $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection<int, Equipo>
     */
    public function getEquipos(): Collection
    {
        return $this->equipos;
    }

    public function addEquipo(Equipo $equipo): static
    {
        if (!$this->equipos->contains($equipo)) {
            $this->equipos->add($equipo);
            $equipo->setTorneoGeneroCategoria($this);
        }

        return $this;
    }

    public function removeEquipo(Equipo $equipo): static
    {
        if ($this->equipos->removeElement($equipo)) {
            // set the owning side to null (unless already changed)
            if ($equipo->getTorneoGeneroCategoria() === $this) {
                $equipo->setTorneoGeneroCategoria(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable('now');

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable('now');

        return $this;
    }

    /**
     * @return Collection<int, Zona>
     */
    public function getZonas(): Collection
    {
        return $this->zonas;
    }

    public function addZona(Zona $zona): static
    {
        if (!$this->zonas->contains($zona)) {
            $this->zonas->add($zona);
            $zona->setTorneoGeneroCategoria($this);
        }

        return $this;
    }

    public function removeZona(Zona $zona): static
    {
        if ($this->zonas->removeElement($zona)) {
            // set the owning side to null (unless already changed)
            if ($zona->getTorneoGeneroCategoria() === $this) {
                $zona->setTorneoGeneroCategoria(null);
            }
        }

        return $this;
    }

    public function isCerrado(): ?bool
    {
        return $this->cerrado;
    }

    public function setCerrado(bool $cerrado): static
    {
        $this->cerrado = $cerrado;

        return $this;
    }

    public function isCreado(): ?bool
    {
        return $this->creado;
    }

    public function setCreado(bool $creado): static
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * @return Collection<int, PlayOff>
     */
    public function getPlayOffs(): Collection
    {
        return $this->playOffs;
    }

    public function addPlayOff(PlayOff $playOff): static
    {
        if (!$this->playOffs->contains($playOff)) {
            $this->playOffs->add($playOff);
            $playOff->setTorneoGeneroCategoria($this);
        }

        return $this;
    }

    public function removePlayOff(PlayOff $playOff): static
    {
        if ($this->playOffs->removeElement($playOff)) {
            // set the owning side to null (unless already changed)
            if ($playOff->getTorneoGeneroCategoria() === $this) {
                $playOff->setTorneoGeneroCategoria(null);
            }
        }

        return $this;
    }
}
