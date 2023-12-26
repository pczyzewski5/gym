<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\ModelTransformer\TagModelTransformer;
use Gym\Domain\Enum\MuscleTagEnum;
use Gym\Domain\Exercise\Exercise;
use Gym\Domain\Exercise\ExerciseRepository;
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
    public const IMAGE_FIELD = 'image';
    public const EXERCISES_FIELD = 'exercises';

    private ExerciseRepository $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

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
            self::IMAGE_FIELD,
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
        $exercises = $this->exerciseRepository->findAll();

        $result = [];

        /** @var Exercise $exercise */
        foreach ($exercises as $exercise) {
            $result[$exercise->getName()] = $exercise->getId();
        }

        return $result;
    }
}
