<?php declare(strict_types=1);

namespace MrCeperka\SqlFileLoader;

class SqlFileLoader
{

	/** @var resource */
	private $resource;

	/**
	 * SqlFileLoader constructor.
	 * @param $resource
	 */
	public function __construct($resource)
	{
		if (is_resource($resource)) {
			$this->resource = $resource;
		} elseif (file_exists($resource) && is_readable($resource)) {
			$this->resource = fopen($resource, 'r');
		} else {
			throw new \InvalidArgumentException('Resource or filename expected');
		}
	}


	public function getQueries(): \Generator
	{
		$buff = [];
		foreach ($this->lines() as $line) {
			$trimmed = trim($line);
			if ($trimmed === '') {
				continue;
			}

			$lastSemicolonPosition = strrpos($trimmed, ';');
			$lineLength = strlen($trimmed);
			$endsWithSemicolon = $lastSemicolonPosition + 1 === $lineLength;

			if ($endsWithSemicolon) {
				yield implode('', $buff) . $trimmed;
				$buff = [];
			} else {
				$buff[] = $trimmed;
			}
		}
	}

	private function lines(): \Generator
	{
		while ($line = fgets($this->resource)) {
			if ($line === false) {
				break;
			}

			yield $line;
		}
		fclose($this->resource);
	}
}