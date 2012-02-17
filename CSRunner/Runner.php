<?php

namespace CSRunner;

use CSRunner\Scm as Scm;

class Runner {
    
    private $commands;
    private $scm;
    private $filters;
    
    function __construct(
        array $commands,
        Scm $scm,
        array $filters
    ) {
        $this->commands = $commands;
        $this->scm = $scm;
        $this->filters = $filters;
    }
    
    function run(array $directories) {
        $changed_files = $this->scm->getChangedFiles($directories);
        $files = array();
        foreach ($this->filters as $filter) {
            $files = $filter->filter($changed_files);
        }
        foreach ($this->commands as $command) {
            $command->run($files);
        }
    }
}
