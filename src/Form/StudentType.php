<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('age')
            ->add('skype')
            ->add('language')
            ->add('email')
            ->add('joining_date')
            ->add('active')
            ->add('teacher_rate')
            ->add('teacher_remark')
            ->add('parent_remark')
            ->add('created_at')
            ->add('updated_at')
            ->add('student_rate')
            ->add('gender')
            ->add('class_type')
            ->add('teacher')
            ->add('family')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
