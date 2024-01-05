<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\TagDataTransformer;
use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TrainingForm extends AbstractType
{
    public const DATE_FIELD = 'date';
    public const REPEATED_FIELD = 'repeated';
    public const TAGS_FIELD = 'tags';

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
            ['label' => 'Powtarzaj co tydzień'],
        );

        $builder->add(
            self::TAGS_FIELD,
            ChoiceType::class,
            [
                'label' => 'Partie mięśniowe',
                'choices' => \array_combine(MuscleTagEnum::toArray(), MuscleTagEnum::toArray()),
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'data-type' => 'tags',
                    'data-free-input' => 'false',
                    'data-remove-free-input' => 'true',
                    'data-selectable' => 'false',
                    'data-close-dropdown-on-item-select' => 'false',
                    'data-allow-duplicates' => 'false'
                ],
            ]
        );
        $builder->get(self::TAGS_FIELD)->addModelTransformer(new TagDataTransformer());

        $builder->add(
            'zapisz',
            SubmitType::class,
            [
                'attr' => ['class' => 'button is-primary is-fullwidth']
            ]
        );
    }
}
