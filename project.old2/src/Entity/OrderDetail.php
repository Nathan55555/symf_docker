<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $com_id = null;

    #[ORM\Column]
    private ?int $id_art = null;

    #[ORM\Column]
    private ?int $ord_qtn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComId(): ?Commande
    {
        return $this->com_id;
    }

    public function setComId(?Commande $com_id): self
    {
        $this->com_id = $com_id;

        return $this;
    }

    public function getIdArt(): ?int
    {
        return $this->id_art;
    }

    public function setIdArt(int $id_art): self
    {
        $this->id_art = $id_art;

        return $this;
    }

    public function getOrdQtn(): ?int
    {
        return $this->ord_qtn;
    }

    public function setOrdQtn(int $ord_qtn): self
    {
        $this->ord_qtn = $ord_qtn;

        return $this;
    }
}
