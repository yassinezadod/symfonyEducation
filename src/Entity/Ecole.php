<?php

namespace App\Entity;

use App\Repository\EcoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EcoleRepository::class)
 */
class Ecole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $directeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="ecole")
     */
    private $eformation;

    public function __construct()
    {
        $this->eformation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    public function __toString()
    {
        return $this->nom; // Utilisez le champ que vous préférez ici
    }

    public function getDirecteur(): ?string
    {
        return $this->directeur;
    }

    public function setDirecteur(string $directeur): self
    {
        $this->directeur = $directeur;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getEformation(): Collection
    {
        return $this->eformation;
    }

    public function addEformation(Formation $eformation): self
    {
        if (!$this->eformation->contains($eformation)) {
            $this->eformation[] = $eformation;
            $eformation->setEcole($this);
        }

        return $this;
    }

    public function removeEformation(Formation $eformation): self
    {
        if ($this->eformation->removeElement($eformation)) {
            // set the owning side to null (unless already changed)
            if ($eformation->getEcole() === $this) {
                $eformation->setEcole(null);
            }
        }

        return $this;
    }
}
