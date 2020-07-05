<?php

return [
  'main_app' => [
    'initRoute' => 'main_app.init',
    'dev' => [
      'path' => isWin() ? 
        'D:\websites\canikickit\frontend\main_app' : 
        '/media/data/websites/canikickit/frontend/main_app',
      'host' => 'localhost',
      'port' => 8080,
      'scripts' => ['vendors.js', 'main_app.js']
    ],
    'build' => [
      'cmd' => 'npm run build',
      'path' => public_path('assets/main_app'),
      'manifest' => public_path('assets/main_app/manifest.json'),
      'scripts' => ['vendors.js', 'main_app.js']
    ],
  ]
];