<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Parser;

use Carbon\CarbonImmutable;

class LogLineParser
{

	//private const string Pattern = '/^\[(.*?)\] (\w+)\.(\w+): (.+?) (({|\[).+?) \[/';
	private const string Pattern = '/^\[(.*?)\] (\w+)\.(\w+): (.+?) (({|\[).+?)$/';


	public function parse(string $line): ?Line
	{
		$matches = [];

		if (!preg_match(self::Pattern, $line, $matches)) {
			// If we can't parse the line, then just return it unparsed.
			return new Line(message: $line);
		}

		///print_r($matches);

		return new Line(
			timestamp: $this->parseTimestamp($matches[1] ?? ''),
			channel: $matches[2] ?? null,
			level: $this->parseLevel($matches[3] ?? null),
			message: $matches[4] ?? null,
			context: $this->parseContext($matches[5] ?? null)
		);
	}

	private function parseTimestamp(?string $text): ?CarbonImmutable
	{
		return CarbonImmutable::parse($text);
	}


	private function parseLevel(?string $text): Level
	{
		if ($text === null)
			return Level::Info;

		return Level::tryFrom($text) ?? Level::Info;
	}


	private function parseContext(?string $text): ?array
	{
		if ($text === null || !json_validate($text))
			return null;

		return json_decode($text, associative: true);
	}
}