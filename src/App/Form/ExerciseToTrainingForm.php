<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ExerciseToTrainingForm extends AbstractType
{
    public const SERIES_GOAL_FIELD = 'series_goal';
    public const REPETITION_GOAL_FIELD = 'repetition_goal';
    public const KILOGRAM_GOAL_FIELD = 'kilogram_goal';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::SERIES_GOAL_FIELD,
            IntegerType::class,
            [
                'label' => 'Serie',
                'required' => true,
                'attr' => [
                    'class' => 'input',
                    'value' => 4
                ],
            ]
        );

        $builder->add(
            self::REPETITION_GOAL_FIELD,
            IntegerType::class,
            [
                'label' => 'Powtórzenia',
                'required' => true,
                'attr' => [
                    'class' => 'input',
                    'value' => 12
                ],
            ]
        );

        $builder->add(
            self::KILOGRAM_GOAL_FIELD,
            IntegerType::class,
            [
                'label' => 'Kg',
                'required' => true,
                'attr' => ['class' => 'input'],
            ]
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
