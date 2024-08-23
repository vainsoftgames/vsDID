
Add script to ````<head>````
```
require('vsDID.php');

define('API_KEY', '[YOUR API KEY]');

```

Using class
```php
<?php
$vsdid = new vsDID();
$vsdid->api_key = API_KEY;

// Text Script
$results = $vsdid->createScriptText('[URL TO IMG]', 'Text for script', $subTitles=false, $ssml=false, $provider=false);

// Audio File Script
$results = $vsdid->createScriptAud('[URL to IMG]', '[AUDIO FILE URL]',  $subTitles=false, $reduce_noise=false

?>
```

Getting talks
```php
// Get Talk by ID
$vsdid->getTalk('[ID]');

// Getting all talks
$vsdid->getTalk();
```
