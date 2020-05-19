<?php

namespace App\Form;

use App\Entity\Currency;
use App\Entity\Employee;
use App\Entity\EmployeeCategory;
use App\Entity\SalaryPackage;
use App\Entity\Time;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('fatherName')
            ->add('cnic', null, [
                'label' => 'Occupation'
            ])
            ->add('address')
            ->add('email')
            ->add('mobile')
            ->add('telephone')
            ->add('birthday', BirthdayType::class, [
                'label' => 'DoB',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ]
            ])
            ->add('nationality')
            ->add('skype', null, [
                'label' => 'Skype ID'
            ])
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('joining_at', DateType::class, [
                'label' => 'Joining Date',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day',
                ]
            ])
            ->add('ijaazah')
            ->add('zoom')
            ->add('marital_status', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Married' => 'Married',
                    'Single' => 'Single',
                ]
            ])
            ->add('institute_email')
            ->add('experience')
            ->add('qualification')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Female' => 'Female',
                    'Male' => 'Male',
                ]
            ])
            ->add('salaryPackage', EntityType::class, [
                // looks for choices from this entity
                'class' => SalaryPackage::class,
                'choice_label' => 'salary',
                'placeholder' => 'Salary Package'
            ])
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => EmployeeCategory::class,
                'choice_label' => 'name',
                'label' => 'Designation',
                'placeholder' => 'Designation'
            ])
            ->add('startTime1', ChoiceType::class, [
                'label' => 'Start Time 1',
                'choice_label' => 'list',
                'class' => Time::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.list', 'DESC');
                },
            ])
            ->add('endTime1', EntityType::class, [
                'label' => 'End Time 1',
                'choice_label' => 'list',
                'class' => Time::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.list', 'DESC');
                },
            ])
            ->add('startTime2', EntityType::class, [
                'label' => 'Start Time 2',
                'choice_label' => 'list',
                'class' => Time::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.list', 'DESC');
                },
            ])
            ->add('endTime2', EntityType::class, [
                'label' => 'End Time 2',
                'choice_label' => 'list',
                'class' => Time::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.list', 'DESC');
                },
            ])
            ->add('startTime3', EntityType::class, [
                'label' => 'Start Time 3',
                'choice_label' => 'list',
                'class' => Time::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.list', 'DESC');
                },
            ])
            ->add('endTime3', EntityType::class, [
                'label' => 'End Time 3',
                'choice_label' => 'list',
                'class' => Time::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.list', 'DESC');
                },
            ])
            ->add('bank')
            ->add('branch')
            ->add('currency', EntityType::class, [
                'label' => 'Currency',
                'choice_label' => 'code',
                'required' => false,
                'class' => Currency::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
            ])
            ->add('medical')
            ->add('entertainment')
            ->add('misc')
            ->add('account_title')
            ->add('account_no')
            ->add('salary_amount', null, [
                'label' => 'Monthly Salary'
            ])
            ->add('eobi')
            ->add('whatsup_group')
            ->add('hour_rate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
