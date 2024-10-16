<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\ManyToOne(inversedBy: 'userEvaluation')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    private ?Fournisseur $evaluationFournisseur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $systemeManagementQualite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $respectCriteresQualite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $respectSpecificationsProduit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aspectGeneraleProcessusFabrication = null;


     /////Inserer le Hydrate
     public function hydrate(array $init)
     {        
         foreach ($init as $propriete => $valeur) 
         {   $nomSet = "set" . ucfirst($propriete);
             if (!method_exists($this, $nomSet)) 
             {                
                 // à nous de voir selon le niveau de restriction...                
                 // throw new Exception("La méthode {$nomSet} n'existe pas");
             }          
             else {               
                 // appel au set                
                 $this->$nomSet($valeur);            
             }        
         }    
     } 
     public function __construct(array $init=[])
   {
       $this->hydrate($init);
   }   
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEvaluationFournisseur(): ?Fournisseur
    {
        return $this->evaluationFournisseur;
    }

    public function setEvaluationFournisseur(?Fournisseur $evaluationFournisseur): static
    {
        $this->evaluationFournisseur = $evaluationFournisseur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSystemeManagementQualite(): ?string
    {
        return $this->systemeManagementQualite;
    }

    public function setSystemeManagementQualite(?string $systemeManagementQualite): static
    {
        $this->systemeManagementQualite = $systemeManagementQualite;

        return $this;
    }

    public function getRespectCriteresQualite(): ?string
    {
        return $this->respectCriteresQualite;
    }

    public function setRespectCriteresQualite(?string $respectCriteresQualite): static
    {
        $this->respectCriteresQualite = $respectCriteresQualite;

        return $this;
    }

    public function getRespectSpecificationsProduit(): ?string
    {
        return $this->respectSpecificationsProduit;
    }

    public function setRespectSpecificationsProduit(?string $respectSpecificationsProduit): static
    {
        $this->respectSpecificationsProduit = $respectSpecificationsProduit;

        return $this;
    }

    public function getAspectGeneraleProcessusFabrication(): ?string
    {
        return $this->aspectGeneraleProcessusFabrication;
    }

    public function setAspectGeneraleProcessusFabrication(?string $aspectGeneraleProcessusFabrication): static
    {
        $this->aspectGeneraleProcessusFabrication = $aspectGeneraleProcessusFabrication;

        return $this;
    }
}
