<?php

namespace CSRunner;

use CSRunner\Scm as Scm;

class Runner {
    
    private $phpcs;
    private $scm;
    private $filters;
    
    function __construct(
        $phpcs,
        Scm $scm,
        array $filters
    ) {
        $this->phpcs;
        $this->scm = $scm;
        $this->filters = $filters;
    }
    
    function run(array $directories) {
        $changed_files = $this->scm->getChangedFiles($directories);
        $files = array();
        foreach ($this->filters as $filter) {
            $files = $filter->filter($changed_files);
        }
        system("{$this->phpcs} {$files}");
    }
}