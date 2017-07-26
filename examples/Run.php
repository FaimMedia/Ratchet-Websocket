#!/usr/bin/env php
<?php

use FaimMedia\Websocket\App;

define('ROOT_PATH', dirname(realpath(__FILE__)).'/../');

if(file_exists(ROOT_PATH.'vendor/autoload.php')) {
	require ROOT_PATH.'vendor/autoload.php';
}

require 'ExampleServer.php';

// Set defaults
	$wsDomain = '0.0.0.0';
	$wsPort = 9010;
	$wsHost = 'localhost';

	$showHelp = false;

	for($i = 1; $i < count($argv); $i += 2) {
		$key = $argv[$i];
		$value = @$argv[$i + 1];

		if($key == '-port') {
			$wsPort = (int)$value;
		}

		if($key == '-host') {
			$wsHost = $value;
		}

		if($key == '-domain') {
			$wsDomain = $value;
		}

		if($key == '--help') {
			$showHelp = true;
		}
	}

	if($showHelp) {
		echo '-port'.PHP_EOL;
		echo '	Change websocket port, default 9010';
		echo PHP_EOL;
		echo '-host'.PHP_EOL;
		echo '	Change the listening host, default localhost';
		echo PHP_EOL;
		echo '-domain'.PHP_EOL;
		echo '	Change the domain IP-address, default 0.0.0.0';
		echo PHP_EOL;

		die;
	}

// Initialize websocket applications
	$exampleApp = new ExampleServer();

// Run websocket
	$app = new App($wsDomain, $wsPort, $wsDomain);
	$app->route('/ws', $exampleApp, ['*'], $wsHost);

	echo "\033[0;30m\033[42mRunning Websocket server on ".$wsDomain." (port: ".$wsPort.')';
	echo "\033[0m".PHP_EOL;

	$app->run();