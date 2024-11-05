<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Evaluation;
use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', IntegerType::class)
            ->add('commentaire', TextareaType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
            ])
            ->add('evaluationFournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom',
            ])
            ->add('systemeManagementQualite', TextType::class)
            ->add('respectCriteresQualite', TextType::class)
            ->add('respectSpecificationsProduit', TextType::class)
            ->add('aspectGeneraleProcessusFabrication', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
