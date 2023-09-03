<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="IDX_5FB6DEC7305E0476", columns={"id_rec_id"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: ReponseRepository::class)]

class Reponse
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rec_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(inversedBy: 'reponse')]
    private ?Reclamation  $idRec = null;
        /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_reponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getIdRec(): ?Reclamation
    {
        return $this->idRec;
    }

    public function setIdRec(?Reclamation $idRec): self
    {
        $this->idRec = $idRec;

        return $this;
    }

    public function getDateReponse(): ?\DateTimeInterface
    {
        return $this->date_reponse;
    }

    public function setDateReponse(?\DateTimeInterface $date_reponse): self
    {
        $this->date_reponse = $date_reponse;

        return $this;
    }


}
