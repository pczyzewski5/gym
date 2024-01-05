<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\TagDataTransformer;
use App\Form\EventListener\UploadedImageEventSubscriber;
use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ExerciseForm extends AbstractType
{
    public const NAME_FIELD = 'name';
    public const DESCRIPTION_FIELD = 'description';
    public const TAGS_FIELD = 'tags';
    public const SEPARATE_LOAD_FIELD = 'separate_load';
    public const IMAGE_FIELD = 'image';
    public const IMAGE_UPLOAD_FIELD = 'image_upload';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new UploadedImageEventSubscriber());

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
            self::TAGS_FIELD,
            ChoiceType::class,
            [
                'label' => 'Partia mięśniowa',
                'choices' => \array_combine(MuscleTagEnum::toArray(), MuscleTagEnum::toArray()),
                'multiple' => false,
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
            self::SEPARATE_LOAD_FIELD,
            CheckboxType::class,
            ['label' => 'Oddzielne obciążenie per ręka']
        );

        $builder->add(
            self::IMAGE_FIELD,
            HiddenType::class,
            ['required' => false]
        );

        $builder->add(
            self::IMAGE_UPLOAD_FIELD,
            FileType::class,
            [
                'label' => 'Zdjęcie',
                'required' => false,
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
