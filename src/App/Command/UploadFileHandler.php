<?php

declare(strict_types=1);

namespace App\Command;

use App\ImageOptimizer;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileHandler
{
    private ImageOptimizer $imageOptimizer;
    private SluggerInterface $slugger;
    private array $itemCardImagesAllowedMime;
    private string $itemCardImagesDirectory;

    public function __construct(
        ImageOptimizer $imageOptimizer,
        SluggerInterface $slugger,
        array $itemCardImagesAllowedMime,
        string $itemCardImagesDirectory
    ) {
        $this->imageOptimizer = $imageOptimizer;
        $this->slugger = $slugger;
        $this->itemCardImagesAllowedMime = $itemCardImagesAllowedMime;
        $this->itemCardImagesDirectory = $itemCardImagesDirectory;
    }

    public function handle(UploadFile $command): string
    {
        $uploadedFile = $command->getUploadedFile();

        if (false === \in_array($uploadedFile->getMimeType(), $this->itemCardImagesAllowedMime)) {
            $message = \sprintf(
                'Invalid mime type: %s, allowed are: %s.',
                $uploadedFile->getMimeType(),
                \implode(', ', $this->itemCardImagesAllowedMime)
            );
            throw new UploadException($message);
        }

        $newFilename = \sprintf(
            '%s-%s.%s',
            $this->slugger->slug($uploadedFile->getFilename()),
            uniqid(),
            $uploadedFile->guessExtension()
        );
        $uploadedFile->move($this->itemCardImagesDirectory, $newFilename);

        $this->imageOptimizer->resize($this->itemCardImagesDirectory . '/' . $newFilename);

        return $newFilename;
    }
}
