<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\ModelTransformer\TagModelTransformer;
use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ExerciseForm extends AbstractType
{
    public const NAME_FIELD = 'name';
    public const TAG_FIELD = 'tag';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::NAME_FIELD,
            TextType::class,
            [
                'label' => 'Nazwa',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::TAG_FIELD,
            ChoiceType::class,
            [
                'label' => 'Partia mięśni',
                'choices' => MuscleTagEnum::toArray(),
                'block_prefix' => 'select_type',
            ]
        );
        $builder->get(self::TAG_FIELD)->addModelTransformer(
            new TagModelTransformer()
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
