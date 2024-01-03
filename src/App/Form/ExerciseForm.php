<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\ModelTransformer\TagModelTransformer;
use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ExerciseForm extends AbstractType
{
    public const NAME_FIELD = 'name';
    public const DESCRIPTION_FIELD = 'description';
    public const TAG_FIELD = 'tag';
    public const IMAGE_FIELD = 'image';

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
            self::DESCRIPTION_FIELD,
            TextareaType::class,
            [
                'label' => 'Opis',
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
            self::IMAGE_FIELD,
            FileType::class,
            [
                'label' => 'Zdjęcie',
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypes' => ['image/jpeg', 'image/x-png'],
                        'mimeTypesMessage' => 'Please upload jpg image.',
                    ])
                ],
                'attr' => ['class' => 'file-input']
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
