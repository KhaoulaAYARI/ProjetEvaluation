<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Fournisseur $commandeFournisseur = null;

    /**
     * @var Collection<int, DetailCommande>
     */
    #[ORM\OneToMany(targetEntity: DetailCommande::class, mappedBy: 'commandesD')]
    private Collection $commandeDetailCommande;

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
     
    
    public function __construct(array $init)
    {
        $this->commandeDetailCommande = new ArrayCollection();
        $this->hydrate($init);
    }

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

    public function getCommandeFournisseur(): ?Fournisseur
    {
        return $this->commandeFournisseur;
    }

    public function setCommandeFournisseur(?Fournisseur $commandeFournisseur): static
    {
        $this->commandeFournisseur = $commandeFournisseur;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getCommandeDetailCommande(): Collection
    {
        return $this->commandeDetailCommande;
    }

    public function addCommandeDetailCommande(DetailCommande $commandeDetailCommande): static
    {
        if (!$this->commandeDetailCommande->contains($commandeDetailCommande)) {
            $this->commandeDetailCommande->add($commandeDetailCommande);
            $commandeDetailCommande->setCommandesD($this);
        }

        return $this;
    }

    public function removeCommandeDetailCommande(DetailCommande $commandeDetailCommande): static
    {
        if ($this->commandeDetailCommande->removeElement($commandeDetailCommande)) {
            // set the owning side to null (unless already changed)
            if ($commandeDetailCommande->getCommandesD() === $this) {
                $commandeDetailCommande->setCommandesD(null);
            }
        }

        return $this;
    }
}
