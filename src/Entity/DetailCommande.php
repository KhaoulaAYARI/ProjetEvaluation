<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
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

    #[ORM\ManyToOne(inversedBy: 'commandeDetailCommande')]
    private ?Commande $commandesD = null;

    #[ORM\ManyToOne(inversedBy: 'produitDetailCommande')]
    private ?Produit $produits = null;

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

    public function getCommandesD(): ?Commande
    {
        return $this->commandesD;
    }

    public function setCommandesD(?Commande $commandesD): static
    {
        $this->commandesD = $commandesD;

        return $this;
    }

    public function getProduits(): ?Produit
    {
        return $this->produits;
    }

    public function setProduits(?Produit $produits): static
    {
        $this->produits = $produits;

        return $this;
    }
}
