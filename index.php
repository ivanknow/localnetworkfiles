<?php

function getFolderContent($folderPath) {
    $result = [];

    // Check if the path is a directory
    if (is_dir($folderPath)) {
        $result['name'] = basename($folderPath);
        $result['path'] = $folderPath;
        $result['folder'] = true;
        $result['files'] = [];

        // Open the directory
        if ($handle = opendir($folderPath)) {
            // Read directory contents
            while (false !== ($entry = readdir($handle))) {
                // Skip current and parent directories
                if ($entry != "." && $entry != "..") {
                    // Recursively get content for subdirectories
                    $entryPath = $folderPath . '/' . $entry;
                    if (is_dir($entryPath)) {
                        $result['files'][] = getFolderContent($entryPath);
                    } else {
                        // Add file details to the result
                        $result['files'][] = [
                            'name' => $entry,
                            'path' => $entryPath,
                            'folder' => false
                        ];
                    }
                }
            }
            closedir($handle);
        }
    } else {
        // If it's a file, return file details
        $result['name'] = basename($folderPath);
        $result['path'] = $folderPath;
        $result['folder'] = false;
    }

    return $result;
}

// Specify the path to the folder
$folderPath = './uploads';

// Get folder content
$folderContent = getFolderContent($folderPath);

// Convert the result to JSON
$jsonResult = json_encode($folderContent, JSON_PRETTY_PRINT);

// Set headers to indicate JSON content
header('Content-Type: application/json');

// Output the JSON
echo $jsonResult;
