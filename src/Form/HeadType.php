<?php

namespace App\Form;

use App\Entity\Head;
use App\Entity\HeadCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HeadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null, [
                'label' => 'Account Head Title'
            ])
            ->add('note', TextareaType::class, [
                'required' => false
            ])
            ->add('headcategory',EntityType::class, [
                // looks for choices from this entity
                'class' => HeadCategory::class,
                'choice_label' => 'name',
                'label' => 'Account Category'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Head::class,
        ]);
    }
}
