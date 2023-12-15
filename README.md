
Add script to ````<head>````
```
require('vsDID.php');

define('API_KEY', '[YOUR API KEY]');

```

Using class
```
<?php
$vsdid = new vsDID();

// Text Script
$results = $vsdid->createScriptText('[URL TO IMG]', 'Text for script', $subTitles=false, $ssml=false, $provider=false);

// Audio File Script
$results = $vsdid->createScriptAud('[URL to IMG]', '[AUDIO FILE URL]',  $subTitles=false, $reduce_noise=false

?>
```

Getting talks
```
// Get Talk by ID
$vsdid->getTalk('[ID]');

// Getting all talks
$vsdid->getTalk();
```
