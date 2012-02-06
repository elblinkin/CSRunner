<?php

namespace CSRunner\Scm;

use CSRunner\Scm;

class Git implements Scm {

    private $remote;
    private $branch;
    private $window;
    
    function __construct(
        $remote,
        $branch,
        $window = 5
    ) {
        $this->remote = $remote;
        $this->branch = $branch;
        $this->window = $window;
    }
    
    function getChangedFiles(array $directories = array()) {
        $dirs = empty($directories) ? '.' : implode(' ' , $directories);
        
        exec(
            "git diff {$this->remote}/{$this->branch} --name-only --diff-filter=ACMR -- {$dirs} | grep -v orig || echo ''",
            $changed
        );
        
        exec(
            "git log --format='%H' --since='-{$this->window} days ago' | tail -n1",
            $old_sha
        );
        if (!empty($old_sha)) {
            $old_sha = $old_sha[0];
            exec(
                "git diff --name-only {$old_sha}..HEAD -- {$dirs} | sed '/^$/d' | uniq || echo ''",
                $changed
            );
        }
        
        return array_filter(array_unique($changed), 'file_exists');
    }
}