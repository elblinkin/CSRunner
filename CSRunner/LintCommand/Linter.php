<?php

namespace CSRunner\LintCommand;

class Linter {

    const SOURCE_PREFIX = 'LintCommand.PHP.Lint.';

    private $php_lint_command;

    public function __construct(
        $php_lint_command
    ) {
        $this->php_lint_command = $php_lint_command;
    }

    public function lint($file) {
        print "+ {$this->php_lint_command} {$file}\n";
        exec($this->php_lint_command . ' ' . $file, $output, $return_code);
        $result = array();
        $result['name'] = $file;
        $result['errors'] = array();
        foreach ($output as $line) {
            if (preg_match(';^Parse error: (.*) on line (\d+)$;', $line, $matches) !== 0) {
                $error = array();
                $error['severity'] = 'error';
                $error['line'] = $matches[2];
                $error['message'] = $matches[1];
                $error['source'] = self::SOURCE_PREFIX . 'ParseError';
                $result['errors'][] = $error;
            } else if (preg_match(';^Strict Standards: (.*) on line (\d+)$;', $line, $matches) !== 0) {
                $error = array();
                $error['severity'] = 'warning';
                $error['line'] = $matches[2];
                $error['message'] = $matches[1];
                $error['source'] = self::SOURCE_PREFIX . 'StrictStandards';
                $result['errors'][] = $error;
            }
            print "\t$line\n";
        }
        return $result;
    }
}