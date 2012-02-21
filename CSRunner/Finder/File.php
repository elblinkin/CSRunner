<?php

namespace CSRunner\Finder;

use CSRunner\Finder;

class File extends Finder {

    public function find(array $files_and_directories) {
        foreach ($files_and_directories as $file_or_directory) {
            $files = array();

            if (!file_exists($file_or_directory)) {
                // Output warning
                continue;
            }

            if (is_file($file_or_directory)) {
                $files[] = $file_or_directory;
                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $file_or_directory
                )
            );
            foreach ($iterator as $path) {
                if ($path->isFile()) {
                    $files[] = $path;
                }
            }
        }
        return $files;
    }
}
