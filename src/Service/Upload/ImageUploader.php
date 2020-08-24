<?php
declare(strict_types=1);


namespace App\Service\Upload;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ImageUploader
 * @package App\Service\Upload
 */
class ImageUploader
{

    /**
     * @param $imageName
     * @param $targetDirectory
     * @param SluggerInterface $slugger
     * @return string
     */
    public static function uploadImage($imageName, $targetDirectory, SluggerInterface $slugger) : string
    {
            $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageName->guessExtension();

            try {
                $imageName->move(
                    $targetDirectory,
                    $newFilename
                );
            } catch (FileException $e) {
                echo "Сan not upload your image: {$e->getMessage()}" . PHP_EOL;
            }

            return $newFilename;
    }


    /**
     * @param $imagesName
     * @param $targetDirectory
     * @param SluggerInterface $slugger
     * @return array
     */
    public static function uploadImages($imagesName, $targetDirectory, SluggerInterface $slugger) : array
    {
        $allNames = [];
        foreach ($imagesName as $imageName){
            $allNames[] =  ImageUploader::uploadImage($imageName, $targetDirectory, $slugger);
        }
        return $allNames;
    }

}