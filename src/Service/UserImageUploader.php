<?php

// src/Service/UserImageUploader.php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class UserImageUploader
{
    private $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, string $username): string
    {
        $directoryPath = $this->targetDirectory . '/' . $username;
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath);
        }

        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($directoryPath, $fileName);

        return $fileName;
    }
}
