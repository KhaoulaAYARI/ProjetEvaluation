<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailCommandeRepository::class)]
class DetailCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'produitsDetail')]
    private Collection $produitsDet;

    #[ORM\OneToOne(mappedBy: 'commandesDetail', cascade: ['persist', 'remove'])]
    private ?Commande $commandesDet = null;

    //hydrate
    public function hydrate(array $init)    
    {        foreach ($init as $propriete => $valeur) 
        {            $nomSet = "set" . ucfirst($propriete);
                        if (!method_exists($this, $nomSet)) {
                             // à nous de voir selon le niveau de restriction...                // throw new Exception("La méthode {$nomSet} n'existe pas");            
                        }
                        else {                
                            // appel au set                
                            $this->$nomSet($valeur);           
                        }        
                    }    
                }    

    public function __construct(array $init)
    {
        $this->produitsDet = new ArrayCollection();
        $this->hydrate($init);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduitsDet(): Collection
    {
        return $this->produitsDet;
    }

    public function addProduitsDet(Produit $produitsDet): static
    {
        if (!$this->produitsDet->contains($produitsDet)) {
            $this->produitsDet->add($produitsDet);
            $produitsDet->setProduitsDetail($this);
        }

        return $this;
    }

    public function removeProduitsDet(Produit $produitsDet): static
    {
        if ($this->produitsDet->removeElement($produitsDet)) {
            // set the owning side to null (unless already changed)
            if ($produitsDet->getProduitsDetail() === $this) {
                $produitsDet->setProduitsDetail(null);
            }
        }

        return $this;
    }

    public function getCommandesDet(): ?Commande
    {
        return $this->commandesDet;
    }

    public function setCommandesDet(?Commande $commandesDet): static
    {
        // unset the owning side of the relation if necessary
        if ($commandesDet === null && $this->commandesDet !== null) {
            $this->commandesDet->setCommandesDetail(null);
        }

        // set the owning side of the relation if necessary
        if ($commandesDet !== null && $commandesDet->getCommandesDetail() !== $this) {
            $commandesDet->setCommandesDetail($this);
        }

        $this->commandesDet = $commandesDet;

        return $this;
    }
}
