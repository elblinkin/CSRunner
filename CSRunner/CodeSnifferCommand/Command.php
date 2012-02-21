<?php

namespace CSRunner\CodeSnifferCommand;

use CSRunner\Finder;

class Command implements \CSRunner\Command {

    private $phpcs;
    private $finder;

    public function __construct(
        $phpcs,
        Finder $finder
    ) {
        $this->phpcs = $phpcs;
        $this->finder = $finder;
    }

    public function run(array $files_or_directories) {
        $files = $this->finder->find($files_or_directories);
        $names = implode(' ', $files);
        print "+ {$this->phpcs} {$names}\n";
        system("{$this->phpcs} {$names}");
    }
}