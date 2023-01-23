<?php

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

Command::macro('shell', function (string $command, string $path = null) {
    if (! $path) {
        $path = getcwd();
    }

    $process = (Process::fromShellCommandline($command, $path))->setTimeout(null);

    if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
        $process->setTty(true);
    }

    $process->run(function ($type, $line) {
        $this->output->write($line);
    });
});
