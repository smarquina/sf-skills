<?php

namespace App\Form\Project;

use App\Entity\Project\Project;
use App\Form\Type\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddProjectType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'     => ['autofocus' => true],
                'label'    => 'project.name',
                'required' => true,
            ])
            ->add('amount', NumberType::class, [
                'html5'    => true,
                'attr'     => [],
                'help'     => 'project.help.amount',
                'label'    => 'project.amount',
                'required' => true,
            ])
            ->add('startDate', DateType::class, [
                'label'    => 'project.start_date',
                'required' => true,
            ])
            ->addEventListener(FormEvents::SUBMIT, static function (FormEvent $event) {
               // dd($event->getData());
            });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => Project::class,
                               ]);
    }
}
