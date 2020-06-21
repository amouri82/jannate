<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Currency;
use App\Entity\Family;
use App\Entity\InvoiceType;
use App\Entity\Timezone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FamilyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('username')
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('telephone')
            ->add('mobile')
            ->add('city')
            ->add('trialDate', DateType::class, [
                'label' => 'Joining Date',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ]
            ])            ->add('bank')
            ->add('studentBank')
            ->add('payment_mode', ChoiceType::class, [
                'choices' => [
                    'Payment mode' => '',
                    'Bank' => 'Bank',
                    'PayPal' => 'PayPal',
                ]
            ])
            ->add('zoom')
            ->add('country', EntityType::class, [
                // looks for choices from this entity
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Country'
            ])
            ->add('invoice_type', EntityType::class, [
                // looks for choices from this entity
                'class' => InvoiceType::class,
                'choice_label' => 'type',
                'placeholder' => 'Invoice Type'
            ])
            ->add('timezone', EntityType::class, [
                // looks for choices from this entity
                'class' => Timezone::class,
                'choice_label' => 'name',
                'placeholder' => 'Time Zone'
            ])
            ->add('currency', EntityType::class, [
                // looks for choices from this entity
                'class' => Currency::class,
                'choice_label' => 'code',
                'placeholder' => 'Currency'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Family::class,
        ]);
    }
}
