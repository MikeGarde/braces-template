# braces-template
Simple template engine for populating values into a document.

```
require_once('vendor/autoload.php');

use bracesTemplate\bracesTemplate;

$bt     = new bracesTemplate(__DIR__ . '/app/templates');
$fields = [
	'fromStatus'  => 1,
	'toStatus'    => 2,
	'datetime'    => '2016-07-25 12:00:00',
	'description' => 'order approved',
];

$populated = $bt->fill('myRequest.xml', $fields);
```