# braces-template
Simple template engine for populating values into a document.

```
require_once('vendor/autoload.php');

use bracesTemplate\bracesTemplate as bt;

$template = __DIR__ . '/file.xml';
$fields   = [
	'fromStatus'  => 1,
	'toStatus'    => 2,
	'datetime'    => '2016-07-25 12:00:00',
	'description' => 'order approved',
];

$request = bt::fill($template, $fields, true);
```