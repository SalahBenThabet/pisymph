<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="IDX_CE606404C09A1CAE", columns={"id_cat_id"}), @ORM\Index(name="IDX_CE60640479F37AE5", columns={"id_user_id"}), @ORM\Index(name="id_reponse", columns={"id_reponse"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: ReclamationRepository::class)]

class Reclamation
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
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]

    private ?string $description = null;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_id", referencedColumnName="id")
     * })
     */


    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cat_id", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(inversedBy: 'reclamation')]
    private ?Categorie  $idCat = null;

    /**
     * @var Reponse
     *
     * @ORM\ManyToOne(targetEntity="Reponse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reponse", referencedColumnName="id")
     * })
     */
    #[ORM\ManyToOne(inversedBy: 'reclamation')]
    private ?Reponse $idReponse = null;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_envoi = null;

    #[ORM\Column]
    private ?int $id_user = null;

    public function getId(): ?int
    {
        return $this->id;
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


    public function getIdCat(): ?Categorie
    {
        return $this->idCat;
    }

    public function setIdCat(?Categorie $idCat): self
    {
        $this->idCat = $idCat;

        return $this;
    }

    public function getIdReponse(): ?Reponse
    {
        return $this->idReponse;
    }

    public function setIdReponse(?Reponse $idReponse): self
    {
        $this->idReponse = $idReponse;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi(?\DateTimeInterface $date_envoi): self
    {
        $this->date_envoi = $date_envoi;

        return $this;
    }




    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
