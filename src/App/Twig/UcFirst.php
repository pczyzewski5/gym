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
            new TwigFilter('ucfirst', 'ucfirst')
        ];
    }
}
