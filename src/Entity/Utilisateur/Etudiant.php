<?php

namespace App\Entity\Utilisateur;

use App\Entity\InfoEtudiant\Filiere;
use App\Entity\InfoEtudiant\Niveau;
use App\Repository\Utilisateur\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 * @ORM\Table(name="Etudiants")
 */
class Etudiant extends Utilisateur
{
    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private Filiere $filiere;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private Niveau $niveau;

    public function __construct()
    {
        $this->roles = ['ROLE_ETUDIANT'];
    }

    public function getFiliere(): Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getNiveau(): Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}
