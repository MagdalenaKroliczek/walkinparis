<?php

namespace App\Form;

use App\Entity\Walk;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WalkFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', Type\TextType::class)
            ->add('date', Type\DateTimeType::class, [
                'data' => new \DateTime(),
                'date_format' => 'dd-MM-yyyy HH:mm',
                'format' => 'dd-MM-yyyy HH:mm',
                "widget" => 'single_text',
            ])
            ->add('description', Type\TextareaType::class)
            ->add('image', Type\FileType::class, [
                'mapped' => false
            ] )
            ->add('save', Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Walk::class,
        ]);
    }
}
