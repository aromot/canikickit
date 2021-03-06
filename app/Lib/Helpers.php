<?php

function dbg($anything): void
{
  $file = storage_path('logs/debug.log');
  $content = is_scalar($anything) ? $anything : print_r($anything, 1);

  file_put_contents($file, $content."\n", FILE_APPEND);
}

function isDev(): bool
{
  return strtolower(env('APP_ENV')) === 'dev';
}

function makePathDir(string $path, $mode = 0777): bool
{
  $dir = dirname($path);

  return file_exists($dir) ? true : mkdir($dir, $mode, true);
}

function public_path(string $path): string
{
  return base_path(empty($path) ? 'public' : 'public/' . ltrim($path, '/\\'));
}

function isWin(): bool
{
  return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
}