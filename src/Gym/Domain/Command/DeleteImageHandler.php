<?php

declare(strict_types=1);

namespace Gym\Domain\Command;

class DeleteImageHandler
{
    private string $photosDir;

    public function __construct(string $photosDir)
    {
        $this->photosDir = $photosDir;
    }

    public function handle(DeleteImage $command): void
    {
        $filepath = $this->photosDir . '/' . $command->getFilename();

        if (\file_exists($filepath)) {
            \unlink($filepath);
        }
    }
}
