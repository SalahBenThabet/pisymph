<?php

namespace App\Entity;

use App\Repository\EspaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Espace
 *
 * @ORM\Table(name="espace", indexes={@ORM\Index(name="fk_typespace", columns={"id_type"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: EspaceRepository::class)]
class Espace
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer", nullable=false)
     */
    #[ORM\Column]
    private ?int $capacite=null;  

    /**  
     * @var string  
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    /**
     * @var Typespace
     *
     * @ORM\ManyToOne(targetEntity="Typespace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(inversedBy: 'espace')]
    private ?Typespace  $idType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdType(): ?Typespace
    {
        return $this->idType;
    }

    public function setIdType(?Typespace $idType): self
    {
        $this->idType = $idType;

        return $this;
    }


}
