<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\ModelTransformer\TagModelTransformer;
use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class ExerciseForm extends AbstractType
{
    public const SERIES_TARGET_FIELD = 'series_target';
    public const REPETITION_TARGET_FIELD = 'repetition_target';
    public const TAG_FIELD = 'tag';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::TAG_FIELD,
            ChoiceType::class,
            [
                'label' => 'Mięsień',
                'choices' => \array_combine(MuscleTagEnum::toArray(), MuscleTagEnum::toArray()),
                'required' => true,
            ]
        );
        $builder->get(self::TAG_FIELD)->addModelTransformer(
            new TagModelTransformer()
        );

        $builder->add(
            self::SERIES_TARGET_FIELD,
            IntegerType::class,
            [
                'label' => 'Ilość serii',
                'required' => true,
                'attr' => [
                    'value' => '4',
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
    }
}
