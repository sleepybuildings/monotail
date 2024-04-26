<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Tail;

use Generator;

class TailFile
{


	public function tail(string $filename): Generator
	{
		$handle = fopen($filename, 'r');
		$line = '';
		$openingFile = true;

		try {
			while (true) {
				$char = fread($handle, 1);

				if ($char !== PHP_EOL) {
					$line .= $char;
					continue;
				}

				if ($openingFile) {
					$openingFile = false;
					continue;
				}

				if ($line)
					yield $line;

				$line = '';
			}


		} finally {
			fclose($handle);
		}
	}

}