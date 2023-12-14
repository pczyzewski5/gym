<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TrainingForm extends AbstractType
{
    public const DATE_FIELD = 'date';
    public const REPEATED_FIELD = 'repeated';
    public const EXERCISES_FIELD = 'exercises';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::DATE_FIELD,
            DateType::class,
            [
                'label' => 'Data treningu',
                'input'  => 'datetime_immutable',
                'widget' => 'single_text',
                'attr' => ['class' => 'input'],
                'required' => true,
            ],
        );

        $builder->add(
            self::REPEATED_FIELD,
            CheckboxType::class,
            [
                'label' => 'Powtarzaj co tydzień'
            ],
        );

        $builder->add(
            self::EXERCISES_FIELD,
            CollectionType::class,
            [
                'label' => 'Cel treningu',
                'entry_type' => ExerciseForm::class,
                'allow_add' => true,
            ],
        );

        $builder->add(
            'zapisz',
            SubmitType::class,
            [
                'attr' => ['class' => 'button is-primary is-fullwidth']
            ]
        );
    }
}
