<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $matriculeProduit = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prixProduit = null;

    #[ORM\ManyToOne(inversedBy: 'produitsFournisseur')]
    private ?Fournisseur $produitsF = null;


// //j'ai ajouté la methode setFournisseur
    private $fournisseur;

    public function hydrate(array $init)
    {
        foreach ($init as $propriete => $valeur) {
            $nomSet = "set" . ucfirst($propriete);
            if (!method_exists($this, $nomSet)) {
                // à nous de voir selon le niveau de restriction...                // throw new Exception("La méthode {$nomSet} n'existe pas");            
            } else {
                // appel au set                
                $this->$nomSet($valeur);
            }
        }
    }

    
    public function __construct(array $init)
    {
        $this->hydrate($init);
    }


    public function setFournisseur(Fournisseur $fournisseur): void
    {
        $this->fournisseur = $fournisseur;
    }
// //j'ai ajouté la methode setDetailCommande

    private $detailCommande;

    public function setDetailCommande(DetailCommande $detailCommande): void
    {
        $this->detailCommande = $$detailCommande;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatriculeProduit(): ?string
    {
        return $this->matriculeProduit;
    }

    public function setMatriculeProduit(string $matriculeProduit): static
    {
        $this->matriculeProduit = $matriculeProduit;

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

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): static
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getProduitsF(): ?Fournisseur
    {
        return $this->produitsF;
    }

    public function setProduitsF(?Fournisseur $produitsF): static
    {
        $this->produitsF = $produitsF;

        return $this;
    }


}
