<?php

declare(strict_types=1);

namespace Sleepybuildings\Monotail\Command;

use Sleepybuildings\Monotail\Output\FormatLine;
use Sleepybuildings\Monotail\Parser\LogLineParser;
use Sleepybuildings\Monotail\Tail\TailFile;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'app:tail',
	description: 'Tails the given monolog file.',
	hidden: false,

)]
class Monotail extends Command
{

	public function __construct(
		private readonly TailFile      $tail,
		private readonly LogLineParser $parser,
		private readonly FormatLine    $formatter,
	)
	{
		parent::__construct();
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$filename = $input->getArgument('filename');
		if (!file_exists($filename)) {
			$output->writeln('The file cannot be found.');
			return Command::FAILURE;
		}

		foreach ($this->tail->tail($filename) as $line) {
			$parsedLine = $this->parser->parse($line);

			if ($parsedLine) {
				$outputLine = $this->formatter->format($parsedLine);

				if ($outputLine) {
					$output->writeln($outputLine);
				}
			}

		}

		return Command::SUCCESS;
	}


	protected function configure(): void
	{
		$this->addArgument('filename', InputArgument::REQUIRED);
	}

}