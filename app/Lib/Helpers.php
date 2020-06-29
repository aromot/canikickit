<?php

function dbg($anything): void
{
  $file = storage_path('logs/debug.log');
  $content = is_scalar($anything) ? $anything : print_r($anything, 1);

  file_put_contents($file, $content, FILE_APPEND);
}