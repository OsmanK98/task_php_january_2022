<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;

class RemoveFileService
{
    public function __construct(private Filesystem $filesystem,
                                private $mediaObjectPath)
    {
    }

    public function remove(string $file)
    {
        try {
            $this->filesystem->remove($this->mediaObjectPath . $file);
        } catch (FileNotFoundException $e) {
            throw new FileNotFoundException($e->getMessage());
        }
    }
}
