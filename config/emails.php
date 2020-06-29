<?php

// if(isDev())
// {
  return array (
    // 'pathTemplates' => realpath(dirname(__FILE__).'/../emails'),
    'pathDumps' => storage_path('emails'),
    'noReplyEmail' => 'no-reply@canikickit.com',
    'noReplyName' => 'Can I Kick It (no reply)',
    'webmasterEmail' => 'webmaster@canikickit.com',
    'webmasterName' => 'Webmaster',
  );

// } else {
//   return array (
//     'pathTemplates' => realpath(dirname(__FILE__).'/../emails'),
//     'pathDumps' => storagePath('emails'),
//     'noReplyEmail' => 'no-reply@faktclub.com',
//     'noReplyName' => 'Faktclub',
//     'webmasterEmail' => 'samuel.desramont@gmail.com',
//     'webmasterName' => 'Webmaster Faktclub',
//     'sendSettings' => [
//       'engine' => 'smtp',
//       'host' => 'smtp.hostinger.com',
//       'port' => 587,
//       'user' => 'no-reply@faktclub.com',
//       'password' => 'Ncoy8901+'
//     ]
//   );
// }