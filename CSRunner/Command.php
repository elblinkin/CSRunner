<?php

namespace CSRunner;

interface Command {

    public function run(array $files_or_directories);
}