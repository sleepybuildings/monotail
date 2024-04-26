<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Output;

readonly class Color
{
	public function __construct(
		public int $r,
		public int $g,
		public int $b,
	)
	{
	}
}