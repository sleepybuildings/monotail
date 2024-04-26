<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Output;

use Sleepybuildings\Monotail\Parser\Level;
use Sleepybuildings\Monotail\Parser\Line;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class FormatLine
{
	private const int MinLabelLength = 6;

	private OutputFormatterStyle $message;
	private OutputFormatterStyle $date;

	private JsonFormatter $jsonFormatter;

	private array $levelStyles;

	public function __construct()
	{
		$this->jsonFormatter = new JsonFormatter();
		$this->date = new OutputFormatterStyle(foreground: '#A3F');
		$this->message = new OutputFormatterStyle(foreground: '#FFF');

		foreach (Level::cases() as $level) {
			$this->levelStyles[$level->value] = new OutputFormatterStyle(
				foreground: '#FFF',
				background: $level->backgroundColor(),
			);
		}
	}

	public function format(Line $line): string
	{
		$result = [];

		if ($line->timestamp)
			$result[] = $this->date->apply($line->timestamp->format('H:i:s'));

		if ($line->level)
			$result[] = $this->formatLevel($line);

		if ($line->message)
			$result[] = $this->message->apply($line->message);

		if (is_array($line->context))
			$result[] = $this->jsonFormatter->format($line->context);


		return join(' ', $result);
	}

	private function formatLevel(Line $line): string
	{
		$label = substr($line->level->label(), 0, self::MinLabelLength);
		$label = str_pad($label, self::MinLabelLength, pad_type: STR_PAD_LEFT);

		return $this->levelStyles[$line->level->value]->apply(' ' . $label . ' ');
	}

	private function formatContext(Line $line): string
	{
		return '???';
	}
}