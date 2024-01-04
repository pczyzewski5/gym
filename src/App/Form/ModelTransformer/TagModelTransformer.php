<?php

declare(strict_types=1);

namespace App\Form\ModelTransformer;

use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\DataTransformerInterface;

class TagModelTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        return $value;
    }

    public function reverseTransform(mixed $value): MuscleTagEnum|array
    {
        $value = \is_array($value) ? $value : [$value];

        return \array_map(
            fn(string $tag) => MuscleTagEnum::from($tag),
            $value
        );
    }
}
