<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    /**
     * @var Collection<int, DetailCommande>
     */
    #[ORM\OneToMany(targetEntity: DetailCommande::class, mappedBy: 'produits')]
    private Collection $produitDetailCommande;

    #[ORM\ManyToOne(inversedBy: 'produitsF')]
    private ?Fournisseur $produitFournisseur = null;

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
        $this->produitDetailCommande = new ArrayCollection();   
        $this->hydrate($init);
   } 
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getProduitDetailCommande(): Collection
    {
        return $this->produitDetailCommande;
    }

    public function addProduitDetailCommande(DetailCommande $produitDetailCommande): static
    {
        if (!$this->produitDetailCommande->contains($produitDetailCommande)) {
            $this->produitDetailCommande->add($produitDetailCommande);
            $produitDetailCommande->setProduits($this);
        }

        return $this;
    }

    public function removeProduitDetailCommande(DetailCommande $produitDetailCommande): static
    {
        if ($this->produitDetailCommande->removeElement($produitDetailCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitDetailCommande->getProduits() === $this) {
                $produitDetailCommande->setProduits(null);
            }
        }

        return $this;
    }

    public function getProduitFournisseur(): ?Fournisseur
    {
        return $this->produitFournisseur;
    }

    public function setProduitFournisseur(?Fournisseur $produitFournisseur): static
    {
        $this->produitFournisseur = $produitFournisseur;

        return $this;
    }
}
