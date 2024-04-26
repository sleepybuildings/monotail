<?php

namespace Sleepybuildings\Monotail\Output;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class JsonFormatter
{
	private OutputFormatterStyle $key;
	private OutputFormatterStyle $number;
	private OutputFormatterStyle $string;
	private OutputFormatterStyle $null;
	private OutputFormatterStyle $boolean;


	public function __construct()
	{
		$this->key = new OutputFormatterStyle(foreground: '#c7c7c7');
		$this->number = new OutputFormatterStyle(foreground: '#b5e68c');
		$this->string = new OutputFormatterStyle(foreground: '#8ce6c5');
		$this->null = new OutputFormatterStyle(foreground: '#d48a5f');
		$this->boolean = new OutputFormatterStyle(foreground: '#d48a5f');
	}


	public function format(array $array): string
	{
		if ($this->is2DArray($array)) {
			//$this->isExceptionArray($array)
			return 'todo';
		}

		return $this->formatAsLine($array);
	}

	private function is2DArray(array $array): bool
	{
		foreach ($array as $value) {
			if (is_array($value)) {
				return true;
			}
		}

		return false;
	}

	public function formatAsLine(array $array): string
	{
		$pairs = [];
		foreach ($array as $key => $value) {
			$pairs[] = $this->key->apply($key) . ': ' . $this->formatValue($value);
		}

		return join('   ', $pairs);
	}

	private function formatValue(mixed $value): string
	{
		return match (true) {
			is_numeric($value) => $this->number->apply($value),
			is_string($value) => $this->string->apply('"' . $value . '"'),
			is_null($value) => $this->null->apply('null'),
			is_bool($value) => $this->boolean->apply($value ? 'true' : 'false'),
			default => $this->string->apply($value)
		};
	}

	private function isExceptionArray(array $array): bool
	{
		return false;
	}
}