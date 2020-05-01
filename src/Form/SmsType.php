<?php

namespace App\Form;

use App\Entity\Sms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service_name')
            ->add('service_number')
            ->add('device_id')
            ->add('sms_user')
            ->add('sms_pass')
            ->add('service_status', CheckboxType::class, array(
                'required' => false,
                'value' => 1,
                'label' => 'Enabled'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sms::class,
        ]);
    }
}
