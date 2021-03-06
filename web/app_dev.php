<?php

//echo $_SERVER['REMOTE_ADDR']; die;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// This is the front controller used when executing the application in the
// development environment ('dev'). See:
//   * https://symfony.com/doc/current/cookbook/configuration/front_controllers_and_kernel.html
//   * https://symfony.com/doc/current/cookbook/configuration/environments.html

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the
// following PHP line. See:
// https://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by
// accident to production servers. Feel free to remove this, extend it, or make
// something more sophisticated.
//if (isset($_SERVER['HTTP_CLIENT_IP'])
//    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
//    || !(in_array($_SERVER['REMOTE_ADDR'], ['192.168.1.22', '192.168.225.20', '122.165.154.34', '192.168.1.29', '192.168.1.28', '192.168.1.203', '192.168.1.101', '192.168.1.102', '127.0.0.1', 'fe80::1', '::1'], true) || PHP_SAPI === 'cli-server')
//) {
//    echo $_SERVER['HTTP_X_FORWARDED_FOR'] . "<br>";
//    echo $_SERVER['REMOTE_ADDR'] . "<br>";
//    header('HTTP/1.0 403 Forbidden');
//    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
//}

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
