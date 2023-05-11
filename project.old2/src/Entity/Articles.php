<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categ_id = null;

    #[ORM\Column(length: 255)]
    private ?string $art_label = null;

    #[ORM\Column]
    private ?int $art_stk = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_Ajout = null;

    #[ORM\Column(length: 255)]
    private ?string $art_picture = null;

    public function __construct()
    {
        $this->Date_Ajout = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategId(): ?Categories
    {
        return $this->categ_id;
    }

    public function setCategId(?Categories $categ_id): self
    {
        $this->categ_id = $categ_id;

        return $this;
    }

    public function getArtLabel(): ?string
    {
        return $this->art_label;
    }

    public function setArtLabel(string $art_label): self
    {
        $this->art_label = $art_label;

        return $this;
    }

    public function getArtStk(): ?int
    {
        return $this->art_stk;
    }

    public function setArtStk(int $art_stk): self
    {
        $this->art_stk = $art_stk;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->Date_Ajout;
    }

    public function setDateAjout(\DateTimeInterface $Date_Ajout): self
    {
        $this->Date_Ajout = $Date_Ajout;

        return $this;
    }

    public function getArtPicture(): ?string
    {
        return $this->art_picture;
    }

    public function setArtPicture(string $art_picture): self
    {
        $this->art_picture = $art_picture;

        return $this;
    }
}
