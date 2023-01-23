<?php

use Illuminate\Support\Facades\File;

/*
 * Creates directories in batch, given a directories array.
 *
 * @var array Directories array to create (e.g.: ['test','john/smith']).
 */
File::macro('makeDirectories', function (array $directories): void {
    foreach ($directories as $directory) {
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0775, true);
        }
    }
});

/**
 * Receives a csv file, and processes each line and cell via a callable.
 *
 * @param $path The csv path
 * @param $process The line function callable (array $line, string $key)
 * @param $cell The cell function callable (strin $cell, string $key)
 *
 * You can use this macro to process each csv line, but also before, to
 * process each cell before processing the line. Each callable receives 2
 * parameters, the first is the context data (a line array for $process() and
 * a cell string for $cell()) and there is no return value from the macro.
 *
 * You can also ignore the first line, in case your csv file has a header
 * column values in the first line.
 */
File::macro('processCsv', function (string $path, callable $process, callable $cell = null, bool $ignoreFirstLine = true): void {
    $file_handle = fopen($path, 'r');

    while (! feof($file_handle)) {
        $lines[] = fgetcsv($file_handle, 1024);
    }

    fclose($file_handle);

    if ($ignoreFirstLine) {
        unset($lines[0]);
    }

    foreach ($lines as $key => $line) {
        if (! is_bool($line)) {
            // Transform 'null' into NULL.
            foreach ($line as $key2 => $cell2) {
                if (trim(strtoupper($cell2)) == 'NULL') {
                    $line[$key2] = null;
                }
            }

            if ($cell) {
                foreach ($line as $key2 => $cell2) {
                    $line[$key2] = $cell($cell2, $key2);
                }
            }

            $process($line, $key);
        }
    }
});
