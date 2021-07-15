<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecettesRepository::class)
 */

class Recettes
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
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $Temps_de_preparation;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $Materiel;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Niveau;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $Instructions;

 

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTempsDePreparation(): ?string
    {
        return $this->Temps_de_preparation;
    }

    public function setTempsDePreparation(string $Temps_de_preparation): self
    {
        $this->Temps_de_preparation = $Temps_de_preparation;

        return $this;
    }

    public function getMateriel(): ?string
    {
        return $this->Materiel;
    }

    public function setMateriel(?string $Materiel): self
    {
        $this->Materiel = $Materiel;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->Niveau;
    }

    public function setNiveau(string $Niveau): self
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->Instructions;
    }

    public function setInstructions(string $Instructions): self
    {
        $this->Instructions = $Instructions;

        return $this;
    }


}
