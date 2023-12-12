<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Photo extends AbstractExtension
{
    private string $imagesDirectory;

    public function __construct(
        string $imagesDirectory
    ) {
        $this->imagesDirectory = $imagesDirectory;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('photo', [$this, 'photo'])
        ];
    }

    public function photo(string $filename): string
    {
        $filepath = $this->imagesDirectory . '/' . $filename;
        $filepath = \preg_replace('/^.+(?=\/photos)/i', '', $filepath);

        return \sprintf(
            'style="background-image: url(%s);"',
            $filepath
        );
    }
}
