# SQL File Loader
---
## Installation
`composer require mrceperka/sql-file-loader`

## Important notes
- Statements in SQL file have to end with `;`
- Loader **does NOT** check the SQL syntax

# Usage
```php
<?php
use \MrCeperka\SqlFileLoader\SqlFileLoader;

$resource = __DIR__ . '/data.sql';
// or with stdin
// $resource = fopen('php://stdin', 'r');

$loader = new SqlFileLoader($resource);
$queries = $loader->getQueries();

```