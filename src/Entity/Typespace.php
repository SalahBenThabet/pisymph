<?php

namespace App\Entity;

use App\Repository\TypespaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Typespace
 *
 * @ORM\Table(name="typespace")
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: TypespaceRepository::class)]

class Typespace
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
     * @ORM\Column(name="typeespace", type="string", length=255, nullable=false)
     */
    #[ORM\Column(length: 255)]
    private  ?string $typeespace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeespace(): ?string
    {
        return $this->typeespace;
    }

    public function setTypeespace(string $typeespace): self
    {
        $this->typeespace = $typeespace;

        return $this;
    }


}
