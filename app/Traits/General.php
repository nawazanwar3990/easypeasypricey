<?php
namespace App\Traits;

trait General
{
    public function makeDirectory($name)
    {
        $dirPath = public_path('uploads/' . $name);
        if (!file_exists($dirPath)) {
            if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }
    public function makeMultipleDirectories($parent, $childs = array())
    {
        foreach ($childs as $child) {
            $dirPath = public_path('uploads/' . $parent . "/" . $child);
            if (!file_exists($dirPath)) {
                if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
                }
            }
        }
    }
    public static function generateFileName($file): string
    {
        $avatarNameWithExt = $file->getClientOriginalName();
        $avatarName = pathinfo($avatarNameWithExt, PATHINFO_FILENAME);
        $avatarName = preg_replace("/[^A-Za-z0-9 ]/", '', $avatarName);
        $avatarName = preg_replace("/\s+/", '-', $avatarName);
        $avatarExtension = $file->getClientOriginalExtension();
        return $avatarName . '_' . time() . '.' . $avatarExtension;
    }
}
