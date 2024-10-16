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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'commandeFournisseur', cascade: ['persist', 'remove'])]
    private Collection $commandes;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'produitFournisseur', cascade: ['persist', 'remove'])]
    private Collection $produitsF;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'evaluationFournisseur', cascade: ['persist', 'remove'])]
    private Collection $evaluations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taille = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localisationGeographique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $certifications = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $technologiesUtilisees = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modesDeLivraison = null;


    

    //Inserer le Hydrate
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
        $this->commandes = new ArrayCollection();
        $this->produitsF = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->hydrate($init);
    }

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

    public function setAdresse(?string $adresse): static
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
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setCommandeFournisseur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCommandeFournisseur() === $this) {
                $commande->setCommandeFournisseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduitsF(): Collection
    {
        return $this->produitsF;
    }

    public function addProduitsF(Produit $produitsF): static
    {
        if (!$this->produitsF->contains($produitsF)) {
            $this->produitsF->add($produitsF);
            $produitsF->setProduitFournisseur($this);
        }

        return $this;
    }

    public function removeProduitsF(Produit $produitsF): static
    {
        if ($this->produitsF->removeElement($produitsF)) {
            // set the owning side to null (unless already changed)
            if ($produitsF->getProduitFournisseur() === $this) {
                $produitsF->setProduitFournisseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setEvaluationFournisseur($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getEvaluationFournisseur() === $this) {
                $evaluation->setEvaluationFournisseur(null);
            }
        }

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getLocalisationGeographique(): ?string
    {
        return $this->localisationGeographique;
    }

    public function setLocalisationGeographique(?string $localisationGeographique): static
    {
        $this->localisationGeographique = $localisationGeographique;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCertifications(): ?string
    {
        return $this->certifications;
    }

    public function setCertifications(?string $certifications): static
    {
        $this->certifications = $certifications;

        return $this;
    }

    public function getTechnologiesUtilisees(): ?string
    {
        return $this->technologiesUtilisees;
    }

    public function setTechnologiesUtilisees(?string $technologiesUtilisees): static
    {
        $this->technologiesUtilisees = $technologiesUtilisees;

        return $this;
    }

    public function getModesDeLivraison(): ?string
    {
        return $this->modesDeLivraison;
    }

    public function setModesDeLivraison(?string $modesDeLivraison): static
    {
        $this->modesDeLivraison = $modesDeLivraison;

        return $this;
    }
}
