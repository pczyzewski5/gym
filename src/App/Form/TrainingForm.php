<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;

class TrainingForm extends AbstractType
{
    public const DATE_FIELD = 'date';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new CallbackTransformer(
            function (mixed $value) {
                return $value;
            },
            function (mixed $value) {
               $value[self::DATE_FIELD] = \DateTimeImmutable::createFromMutable(
                     $value[self::DATE_FIELD]
               );

               return $value;
            }
        ));

        $builder->add(
            self::DATE_FIELD,
            DateType::class,
            [
                'label' => 'Data treningu',
                'required' => true,
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
