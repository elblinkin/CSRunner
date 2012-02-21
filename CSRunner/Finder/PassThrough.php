<?php

namespace CSRunner\Finder;

use CSRunner\Finder;

class PassThrough extends Finder {

    public function find(array $files) {
        return $files;
    }
}