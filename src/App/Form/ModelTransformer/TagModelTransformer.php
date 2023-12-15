<?php

declare(strict_types=1);

namespace App\Form\ModelTransformer;

use Gym\Domain\Enum\MuscleTagEnum;
use Symfony\Component\Form\DataTransformerInterface;

class TagModelTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): ?array
    {
        if (null === $value) {
            return $value;
        } else {
            \var_dump($value);exit;
        }
        \var_dump($value);exit;
        $result = [];

        foreach ($value::toArray() as $data) {
            $result[$data] = $data;
        }

        return $result;
    }

    public function reverseTransform(mixed $value): MuscleTagEnum|array
    {
        $decodedValue = \json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $value = $decodedValue;
        }

        $value = \is_array($value) ? $value : [$value];

        return \array_map(
            fn(string $tag) => MuscleTagEnum::from($tag),
            $value
        );
    }
}
