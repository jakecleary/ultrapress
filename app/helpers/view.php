<?php

/**
 * Return a view.
 *
 * @param  string $file The file path using dot-notation
 * @param  array $data Data to pass through to the view
 * @return UltraPress\View
 */
function view($file, $data = [])
{
    return \UltraPress\View::get($file, $data);
}

/**
 * Return a partial.
 *
 * @param string $file The file path using dot-notation
 * @param array $data Data to pass through to the partial
 * @return UltraPress\View
 */
function partial($file, $data = [])
{
    return \UltraPress\View::partial($file, $data);
}
