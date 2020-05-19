<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Timezone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TimezoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('timezoneDiff')
            ->add('name')
            ->add('phpTimezone')
            ->add('country',EntityType::class, [
                // looks for choices from this entity
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'Country'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Timezone::class,
        ]);
    }
}
