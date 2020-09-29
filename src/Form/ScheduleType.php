<?php

namespace App\Form;

use App\Entity\Schedule;
use App\Entity\Student;
use App\Repository\EmployeeRepository;
use App\Repository\StudentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teacher = $options['teacher'];
        $builder
            ->add('time_start')
            ->add('time_end')
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choices' => $teacher->getStudents(),
                'choice_label' => 'name',
            ]);            
            // ->add('student_time_start')
            // ->add('student_time_end')
            // ->add('admin_time_start')
            // ->add('admin_time_end')
            // ->add('duration')
            //->add('day')
            // ->add('student_day')
            // ->add('admin_day')
            // ->add('status')
            // ->add('create_date_admin')
            // ->add('create_date_teacher')
            // ->add('create_date_student')
            // ->add('public_holiday')
            // ->add('rate')
            // ->add('student_rate')
            // ->add('php_tz')
            // ->add('room')
            // ->add('teacher')
            // ->add('course')
            // ->add('family')
            // ->add('student')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
