<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Employee;
use App\Entity\Status;
use App\Entity\Student;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Student Name'
            ])
            ->add('age')
            ->add('skype')
            ->add('language', ChoiceType::class, [
                'choices' => [
                    'Language' => '',
                    'English' => 'English',
                    'Arabic' => 'Arabic',
                    'Eng-Ara' => 'Eng-Ara',
                ]
            ])
            ->add('email')
            ->add('joining_date', DateType::class, [
                'label' => 'Joining Date',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ]
            ])
            ->add('teacher_rate')
            ->add('teacherRemark', TextareaType::class, [
                'label' => 'Teacher Remark',
                'attr' => ['rows' => 3],
                'required' => false
            ])
            ->add('parent_remark', TextareaType::class, [
                'label' => 'Parent Remark',
                'attr' => ['rows' => 3],
                'required' => false
            ])
            ->add('student_rate')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Gender' => '',
                    'Male' => 'Male',
                    'Female' => 'Female',
                ]
            ])
            ->add('class_type', ChoiceType::class, [
                'choices' => [
                    'Class Type' => '',
                    'Zoom' => 'Zoom',
                    'Others' => 'Others'
                ]
            ])            ->add('teacher', EntityType::class, [
                'required' => false,
                'label' => 'Teacher',
                'class' => Employee::class,
                'choice_label' => 'name'
            ])
            ->add('course', EntityType::class, [
                // looks for choices from this entity
                'class' => Course::class,
                'choice_label' => 'name',
                'placeholder' => 'Course',
                'multiple' => true
            ])
            ->add('manager', EntityType::class, [
                'required' => false,
                'label' => 'Manager',
                'class' => Employee::class,
                'choice_label' => 'name'
            ])
            ->add('regularDate', DateType::class, [
                'label' => 'Regular Date',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ]
            ])
            ->add('status', EntityType::class, [
                // looks for choices from this entity
                'class' => Status::class,
                'choice_label' => 'name',
                'placeholder' => 'Status'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
