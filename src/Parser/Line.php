<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Parser;

use Carbon\CarbonImmutable;

readonly class Line
{

	// public const SIMPLE_FORMAT = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";

	public function __construct(
		public ?CarbonImmutable $timestamp = null,
		public ?string          $channel = null,
		public ?Level           $level = null,
		public ?string          $message = null,
		public ?array           $context = null,
		public ?array           $extra = null,
	)
	{
	}
}