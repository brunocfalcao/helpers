<?php

use Illuminate\Support\Str;

if (! function_exists('empty_stdclass')) {
    function empty_stdclass($object)
    {
        if (strtoupper(class_basename($object)) == 'STDCLASS') {
            return empty((array) $object);
        }

        return blank($object);
    }
}

if (! function_exists('bool_to_str')) {
    function bool_to_str(bool $value)
    {
        if ($value == true) {
            return 'true';
        }

        if ($value == false) {
            return 'false';
        }
    }
}

if (! function_exists('public_ip')) {
    /**
     * Returns the public ip in case the current ip is 127.0.0.1.
     *
     * @return string
     */
    function public_ip()
    {
        try {
            return request()->ip() == '127.0.0.1' ?
                file_get_contents('https://ipinfo.io/ip') :
                request()->ip();
        } catch (\Exception $ex) {
            return request()->ip();
        }
    }
}

if (! function_exists('with_dir_separator')) {
    /**
     * Replaces the separator to the system separator.
     *
     * @param  string  $path  The passed path to replace the separators
     * @return string
     */
    function with_dir_separator(string $path)
    {
        $replacements = ['\\', '/'];

        foreach ($replacements as $replacement) {
            $path = str_replace($replacement, DIRECTORY_SEPARATOR, $path);
        }

        return $path;
    }
}

if (! function_exists('stdclass_to_array')) {
    function stdclass_to_array($obj)
    {
        $reaged = (array) $obj;
        foreach ($reaged as &$field) {
            if (is_object($field)) {
                $field = stdclass_to_array($field);
            }
        }

        return $reaged;
    }
}

if (! function_exists('pick_existing')) {
    /**
     * Given a certain number of values, pick the first that is not empty.
     *
     * @param  array  $args
     * @return mixed|null
     */
    function pick_existing(...$args)
    {
        return collect($args)->first(function ($item) {
            return ! empty($item);
        });
    }
}

if (! function_exists('domain')) {
    /**
     * Returns the current request domain hostname.
     *
     * @param  url A possible url to access on, default is request->getHost()
     * @return string|null
     */
    function domain(string $url = null)
    {
        $pieces = parse_url($url ?? request()->getHost());

        $domain = $pieces['host'] ?? $pieces['path'];

        // Quick check if domain is only one word without dots.
        if (! Str::contains($domain, '.')) {
            return $domain;
        }

        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }

        return null;
    }
}
