<?php


function directoryReader($directory, array $exclude = array('.', '..'))
{
    $files = [];

    if (!is_dir($directory)) {
        return null;
    }

    if (!($filesDirectory = opendir($directory))) {
        return null;
    }

    while (($file = readdir($filesDirectory)) !== false) {
        if (in_array($file, $exclude)) {
            continue;
        }

        $files[] = $directory . DIRECTORY_SEPARATOR . $file;
    }

    closedir($filesDirectory);

    return $files;

}