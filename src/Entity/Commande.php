<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 50)]
    private ?string $statutCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandesFournisseur')]
    private ?Fournisseur $fournisseurCmd = null;

    #[ORM\OneToOne(inversedBy: 'commandesDet', cascade: ['persist', 'remove'])]
    private ?DetailCommande $commandesDetail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getStatutCommande(): ?string
    {
        return $this->statutCommande;
    }

    public function setStatutCommande(string $statutCommande): static
    {
        $this->statutCommande = $statutCommande;

        return $this;
    }

    public function getFournisseurCmd(): ?Fournisseur
    {
        return $this->fournisseurCmd;
    }

    public function setFournisseurCmd(?Fournisseur $fournisseurCmd): static
    {
        $this->fournisseurCmd = $fournisseurCmd;

        return $this;
    }

    public function getCommandesDetail(): ?DetailCommande
    {
        return $this->commandesDetail;
    }

    public function setCommandesDetail(?DetailCommande $commandesDetail): static
    {
        $this->commandesDetail = $commandesDetail;

        return $this;
    }
}
