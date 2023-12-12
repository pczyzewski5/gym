<?php

declare(strict_types=1);

namespace App\Form;

use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ExerciseForm extends AbstractType
{
    public const REPETITION_TARGET_FIELD = 'repetition_target';
    public const KILOGRAM_TARGET_FIELD = 'kilogram_target';
    public const MUSCLE_TAG_FIELD = 'muscle_tag';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new CallbackTransformer(
            function (mixed $value) {
                return $value;
            },
            function (mixed $value) {
                $value[self::MUSCLE_TAG_FIELD] = MuscleTagEnum::from(
                    $value[self::MUSCLE_TAG_FIELD]
                );

                return $value;
            }
        ));

        $builder->add(
            self::MUSCLE_TAG_FIELD,
            ChoiceType::class,
            [
                'label' => 'Obszar',
                'required' => true,
                'choices' => MuscleTagEnum::toArray(),
            ],
        );

        $builder->add(
            self::REPETITION_TARGET_FIELD,
            IntegerType::class,
            [
                'label' => 'Ilość powtórzeń',
                'required' => true,
                'attr' => ['value' => '10']
            ],
        );

        $builder->add(
            self::KILOGRAM_TARGET_FIELD,
            IntegerType::class,
            [
                'label' => 'Ciężar',
                'required' => true,
                'attr' => ['value' => '10']
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
