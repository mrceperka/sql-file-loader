<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;


final class SqlFileLoaderTest extends TestCase
{

	public function testHandlesFilePathAsResource(): void
	{
		$resource = __DIR__ . '/../_data.sql';
		$loader = new \MrCeperka\SqlFileLoader\SqlFileLoader($resource);
		$this->assertEquals(
			["SELECT * FROM 'foo';"],
			iterator_to_array($loader->getQueries())
		);
	}

	public function testHandlesResource(): void
	{
		$resource = __DIR__ . '/../_data.sql';
		$fp = fopen($resource, 'r');

		$loader = new \MrCeperka\SqlFileLoader\SqlFileLoader($fp);
		$this->assertEquals(
			["SELECT * FROM 'foo';"],
			iterator_to_array($loader->getQueries())
		);
	}

	public function testHandlesBigFileWithLowMemoryUsage(): void
	{
		$fp = fopen(__DIR__ . '/../_big.sql', 'r');

		$loader = new \MrCeperka\SqlFileLoader\SqlFileLoader($fp);
		foreach ($loader->getQueries() as $query) {

		}

		// 4 000 000 ~ 4MB
		$this->assertLessThan(4000000, memory_get_usage());
	}
}