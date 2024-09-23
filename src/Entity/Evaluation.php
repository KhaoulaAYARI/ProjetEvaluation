<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'evaluationsFournisseur')]
    private ?Fournisseur $fournisseurEval = null;

    #[ORM\ManyToOne(inversedBy: 'feedback')]
    private ?User $userEval = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getFournisseurEval(): ?Fournisseur
    {
        return $this->fournisseurEval;
    }

    public function setFournisseurEval(?Fournisseur $fournisseurEval): static
    {
        $this->fournisseurEval = $fournisseurEval;

        return $this;
    }

    public function getUserEval(): ?User
    {
        return $this->userEval;
    }

    public function setUserEval(?User $userEval): static
    {
        $this->userEval = $userEval;

        return $this;
    }
}
