<?php

namespace CSRunner\Filter;

use CSRunner\Filter;

class Blacklist implements Filter {

    private $blacklist;
    
    function __construct(array $blacklist) {
        $this->blacklist = $blacklist;
    }
    
    function filter(array $filenames) {
        $ignore_patterns = $this->getIgnorePatterns();
        
        $results = array();
        foreach ($filenames as $filename) {
            if ($this->isBlacklisted($ignore_patterns, $filename) === false) {
                $results[] = $filename;
            }
        }
        return $results;
    }
    
    private function getIgnorePatterns() {
        $ignore_patterns = array();
        $replacements = array(
            '\\,' => ',',
            '*' => '.*',
        );
        foreach ($this->blacklist as $pattern) {
            $ignore_patterns[] = strtr($pattern, $replacements);
        }
        return $ignore_patterns;
    }
    
    private function isBlacklisted($ignore_patterns, $filename) {
        foreach ($ignore_patterns as $pattern) {
            if (preg_match("|{$pattern}|i", $filename) === 1) {
                return true;
            }
        }
        return false;
    }
}
