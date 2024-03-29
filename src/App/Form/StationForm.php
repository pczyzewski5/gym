<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\EventListener\UploadedImageEventSubscriber;
use Gym\Domain\Exercise\Exercise;
use Gym\Domain\Exercise\ExerciseRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class StationForm extends AbstractType
{
    public const NAME_FIELD = 'name';
    public const IMAGE_FIELD = 'image';
    public const EXERCISES_FIELD = 'exercises';
    public const IMAGE_UPLOAD_FIELD = 'image_upload';

    private DataTransformerInterface $exerciseIdModelTransformer;
    private ExerciseRepository $exerciseRepository;

    public function __construct(
        DataTransformerInterface $exerciseIdDataTransformer,
        ExerciseRepository $exerciseRepository
    ) {
        $this->exerciseIdModelTransformer = $exerciseIdDataTransformer;
        $this->exerciseRepository = $exerciseRepository;
    }

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
                'attr' => ['class' => 'file-input'],
            ],
        );

        $builder->add(
            self::EXERCISES_FIELD,
            ChoiceType::class,
            [
                'label' => 'Ćwiczenia',
                'choices' => $this->getExercises(),
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'data-type' => 'tags',
                    'data-free-input' => 'false',
                    'data-remove-free-input' => 'true',
                    'data-selectable' => 'false',
                    'data-close-dropdown-on-item-select' => 'false',
                ],
            ]
        );
        $builder->get(self::EXERCISES_FIELD)->addModelTransformer($this->exerciseIdModelTransformer);

        $builder->add(
            'zapisz',
            SubmitType::class,
            [
                'attr' => ['class' => 'button is-primary is-fullwidth']
            ]
        );
    }

    private function getExercises(): array
    {
        $exercises = $this->exerciseRepository->findAllForList();

        $result = [];

        /** @var Exercise $exercise */
        foreach ($exercises as $exercise) {
            $result[$exercise['name']] = $exercise['id'];
        }

        return $result;
    }
}
