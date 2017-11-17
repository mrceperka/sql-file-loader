<?php
const ROWS_1 = 100000;
if (file_exists(__DIR__ . '/_big.sql')) {
	echo 'Big sql file already exists' . PHP_EOL;

} else {
	echo 'Generating big sql file' . PHP_EOL;

	$filename = __DIR__ . '/_big.sql';
	$i = 0;
	$line = 'SELECT * FROM \'foo\';' . PHP_EOL;
	while ($i < ROWS_1) {
		file_put_contents($filename, $line, FILE_APPEND);
		$i++;
	}

}
