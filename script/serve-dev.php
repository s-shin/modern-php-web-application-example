<?php

if (isset($_SERVER['REQUEST_URI'])) {
    if (preg_match('/.*\.(txt|html|js|css|png|jpg|gif|svg)$/', $_SERVER['REQUEST_URI'])) {
        return false;
    } else {
        require __DIR__ . '/../public/index.php';
    }
    return true;
}

//---

require __DIR__ . '/../vendor/autoload.php';

use Console\CommandLine;

function main()
{
    $parser = new Console_CommandLine([
        'version'     => '1.0.0',
        'description' => '',
    ]);
    $parser->addOption('port', [
        'help_name'   => 'PORT',
        'description' => 'port number',
        'long_name'   => '--port',
        'short_name'  => '-p',
        'action'      => 'StoreInt',
        'default'     => 8080,
    ]);
    try {
        $result = $parser->parse();
        $port = $result->options['port'];
        $routerFile = __FILE__;
        $publicDir = __DIR__ . '/../public/';
        $cmd = "php -S localhost:{$port} -t {$publicDir} {$routerFile}";
        system($cmd, $retval);
        if ($retval) {
            fwrite(STDERR, 'Executing command failed.');
        }
    } catch (Exception $e) {
        fwrite(STDERR, $e->getMessage());
    }
}

main();
