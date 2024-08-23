This will require an account with Team D-ID; https://www.d-id.com/


## Add class to script
```
require('vsDID.php');

define('API_KEY', '[YOUR API KEY]');

```

## Using class
```php
$vsdid = new vsDID();
$vsdid->api_key = API_KEY;

// Text Script
$results = $vsdid->createScriptText('[URL TO IMG]', 'Text for script', $subTitles=false, $ssml=false, $provider=false);

// Audio File Script
$results = $vsdid->createScriptAud('[URL to IMG]', '[AUDIO FILE URL]',  $subTitles=false, $reduce_noise=false
```

## Create Talk
```php
$srcIMG = 'https://example.com/image.png';
$text = 'Hello there';

$config = [];
$config['stitch'] = true;
$config['result_format'] = 'mp4';
$config['output_resolution'] = 1280;

$provider = [];
$provider['type'] = 'microsoft';
$provider['voice_id'] = 'en-US-Travis';

$script = $client->createScript($text, false, false, false, $provider);

$results = $client->createTalk($srcIMG, $script, $config);
```

## Getting talks
```php
// Get Talk by ID
$vsdid->getTalk('[ID]');

// Getting all talks
$vsdid->getTalk();
```
