<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\ModelTransformer\TagModelTransformer;
use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class StationForm extends AbstractType
{
    public const NAME_FIELD = 'name';
    public const PHOTO_FIELD = 'photo';
    public const TAGS_FIELD = 'tags';

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
            self::PHOTO_FIELD,
            FileType::class,
            [
                'label' => 'Zdjęcie',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg', 'image/x-png'],
                        'mimeTypesMessage' => 'Please upload jpg image.',
                    ])
                ],
                'attr' => ['class' => 'file-input']
            ],
        );

        $builder->add(
            self::TAGS_FIELD,
            ChoiceType::class,
            [
                'label' => 'Tagi',
                'choices' => \array_combine(MuscleTagEnum::toArray(), MuscleTagEnum::toArray()),
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'data-type' => 'tags',
                    'data-free-input' => 'false',
                    'data-selectable' => 'false'
                ],
            ]
        );
        $builder->get(self::TAGS_FIELD)->addModelTransformer(
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
