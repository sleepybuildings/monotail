#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Sleepybuildings\Monotail\Command\Monotail;
use Sleepybuildings\Monotail\Output\FormatLine;
use Sleepybuildings\Monotail\Parser\LogLineParser;
use Sleepybuildings\Monotail\Tail\TailFile;
use Symfony\Component\Console\Application;

$application = new Application();

$application->addCommands([
	new Monotail(
		new TailFile(),
		new LogLineParser(),
		new FormatLine($application),
	)
]);
$application->run();