<?php

declare(strict_types=1);

namespace App\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuillType extends AbstractType
{
    private const BLOCK_PREFIX = 'quill_type';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'compound' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
