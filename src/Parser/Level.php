<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Parser;

enum Level: string
{
	case Debug = 'Debug';
	case Info = 'Info';
	case Notice = 'Notice';
	case Warning = 'Warning';
	case Error = 'Error';
	case Critical = 'Critical';
	case Alert = 'Alert';
	case Emergency = 'Emergency';


	public function backgroundColor(): string
	{
		return match ($this) {
			self::Debug => '#cccccc',
			self::Info => '#03a9fc',
			self::Notice => '#03fce3',
			self::Warning => '#fcba03',
			self::Error => '#cf3700',
			self::Critical => '#cf0000',
			self::Alert => '#cf001f',
			self::Emergency => '#cf0000'
		};
	}


	public function label(): string
	{
		return match ($this) {
			self::Debug => 'DBUG',
			self::Info => 'INFO',
			self::Notice => 'NOTICE',
			self::Warning => 'WARNING',
			self::Error => 'ERROR',
			self::Critical => 'CRITICAL',
			self::Alert => 'ALERT',
			self::Emergency => 'EMERGENCY'
		};
	}
}