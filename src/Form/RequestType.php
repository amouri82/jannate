<?php

namespace App\Form;

use App\Entity\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('phone')
            ->add('country')
            ->add('city')
            ->add('message')
            ->add('created_at')
            ->add('time')
            ->add('updated_at')
            ->add('sent')
            ->add('status')
            ->add('origin')
            ->add('subject')
            ->add('title')
            ->add('find')
            ->add('student_name1')
            ->add('student_gender1')
            ->add('student_age1')
            ->add('student_name2')
            ->add('student_gender2')
            ->add('student_age2')
            ->add('student_name3')
            ->add('student_gender3')
            ->add('student_age3')
            ->add('student_name4')
            ->add('student_gender4')
            ->add('student_age4')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
