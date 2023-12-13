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
    public const SERIES_TARGET_FIELD = 'series_target';
    public const REPETITION_TARGET_FIELD = 'repetition_target';
    public const KILOGRAM_TARGET_FIELD = 'kilogram_target';
    public const TAGS_FIELD = 'tags';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new CallbackTransformer(
            function (mixed $value) {
                return $value;
            },
            function (mixed $value) {
                $value[self::TAGS_FIELD] = array_map(
                    fn (string $tag) => MuscleTagEnum::from($tag),
                    $value[self::TAGS_FIELD]
                );

                return $value;
            }
        ));

        $builder->add(
            self::TAGS_FIELD,
            ChoiceType::class,
            [
                'label' => 'Tagi',
                'choices' => MuscleTagEnum::toArray(),
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'data-type' => 'tags',
                    'data-free-input' => 'false'
                ],
            ]
        );

        $builder->add(
            self::SERIES_TARGET_FIELD,
            IntegerType::class,
            [
                'label' => 'Ilość serii',
                'required' => true,
                'attr' => [
                    'value' => '3',
                    'class' => 'input'
                ],
            ],
        );

        $builder->add(
            self::REPETITION_TARGET_FIELD,
            IntegerType::class,
            [
                'label' => 'Ilość powtórzeń',
                'required' => true,
                'attr' => [
                    'value' => '12',
                    'class' => 'input'
                ],
            ],
        );

        $builder->add(
            self::KILOGRAM_TARGET_FIELD,
            IntegerType::class,
            [
                'label' => 'Ciężar',
                'required' => true,
                'attr' => [
                    'value' => '10',
                    'class' => 'input'
                ]
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
