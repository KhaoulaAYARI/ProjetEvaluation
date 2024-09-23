<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'produitsF')]
    private Collection $produitsFournisseur;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'fournisseurEval', cascade:['persist', 'remove'])]
    private Collection $evaluationsFournisseur;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'fournisseurCmd')]
    private Collection $commandesFournisseur;

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
    public function __construct(array $init)    {        
        $this->produitsFournisseur = new ArrayCollection();
        $this->evaluationsFournisseur = new ArrayCollection();
        $this->commandesFournisseur = new ArrayCollection();
        $this->hydrate($init);    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduitsFournisseur(): Collection
    {
        return $this->produitsFournisseur;
    }

    public function addProduitsFournisseur(Produit $produitsFournisseur): static
    {
        if (!$this->produitsFournisseur->contains($produitsFournisseur)) {
            $this->produitsFournisseur->add($produitsFournisseur);
            $produitsFournisseur->setProduitsF($this);
        }

        return $this;
    }

    public function removeProduitsFournisseur(Produit $produitsFournisseur): static
    {
        if ($this->produitsFournisseur->removeElement($produitsFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($produitsFournisseur->getProduitsF() === $this) {
                $produitsFournisseur->setProduitsF(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluationsFournisseur(): Collection
    {
        return $this->evaluationsFournisseur;
    }

    public function addEvaluationsFournisseur(Evaluation $evaluationsFournisseur): static
    {
        if (!$this->evaluationsFournisseur->contains($evaluationsFournisseur)) {
            $this->evaluationsFournisseur->add($evaluationsFournisseur);
            $evaluationsFournisseur->setFournisseurEval($this);
        }

        return $this;
    }

    public function removeEvaluationsFournisseur(Evaluation $evaluationsFournisseur): static
    {
        if ($this->evaluationsFournisseur->removeElement($evaluationsFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($evaluationsFournisseur->getFournisseurEval() === $this) {
                $evaluationsFournisseur->setFournisseurEval(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandesFournisseur(): Collection
    {
        return $this->commandesFournisseur;
    }

    public function addCommandesFournisseur(Commande $commandesFournisseur): static
    {
        if (!$this->commandesFournisseur->contains($commandesFournisseur)) {
            $this->commandesFournisseur->add($commandesFournisseur);
            $commandesFournisseur->setFournisseurCmd($this);
        }

        return $this;
    }

    public function removeCommandesFournisseur(Commande $commandesFournisseur): static
    {
        if ($this->commandesFournisseur->removeElement($commandesFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($commandesFournisseur->getFournisseurCmd() === $this) {
                $commandesFournisseur->setFournisseurCmd(null);
            }
        }

        return $this;
    }
}
