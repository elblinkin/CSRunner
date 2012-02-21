<?php

namespace CSRunner\LintCommand;

use CSRunner\Finder;
use XmlWriter;

class Command implements \CSRunner\Command {

    private $finder;
    private $linter;
    private $reporter;

    public function __construct(
        Finder $finder,
        Linter $linter,
        Reporter $reporter = null
    ) {
        $this->finder = $finder;
        $this->linter = $linter;
        $this->reporter = $reporter;
    }

    
    public function run(array $files_and_directories) {
        $files = $this->finder->find($files_and_directories);
        $results = array();
        foreach ($files as $file) {
            $results[] = $this->linter->lint($file);
        }
        if (isset($this->reporter)) {
            $this->reporter->report($results);
        }
    }
}