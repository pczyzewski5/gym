<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UcFirst extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('ucfirst',  [$this, 'ucfirst'])
        ];
    }

    public function ucfirst(string $string): string
    {
        $result = \mb_strtoupper(
            \mb_substr($string, 0, 1)
        );

        return \trim(
            $result . \mb_substr($string, 1)
        );
    }
}
