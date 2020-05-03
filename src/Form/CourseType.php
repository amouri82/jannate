<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\CourseCategory;
use App\Entity\CourseLevel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('display_name')
            ->add('position')
            ->add('age')
            ->add('image')
            ->add('description')
            ->add('course_level', EntityType::class, [
                'class' => CourseLevel::class,
                'choice_label' => 'level',
            ])
            ->add('course_category', EntityType::class, [
                'class' => CourseCategory::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
