
# Planviewer API Client


# Install Composer
curl -sS https://getcomposer.org/installer | php

# Install dependencies
composer.phar install

#Basic Authentication
You'll need a Client & Secret in order to use Planviewer API's
Log into https://www.planviewer.nl and go to your applications: https://www.planviewer.nl/my_api/applications/

Generate a random Client & Secret.

Add the Client & Secret to /config/config.php

```php
return [
    'api-key' => '86c****7b',
    'api-secret' => '3783******6b3ab4c87fef3ffc*****bb058a72c****cbef2d',
];
```

# Class integration

Add the use to your class or script.
create an instance of the Planviewer object.

```php
use Planviewer/Planviewer

$planviewer = new Planviewer();
```
The Planviewer object contains all our API's. You can access the calls as follows:
```php
/** Access Maps API  */
$planviewer->mapsApi>listViewers();

/** Access Data API  */
$planviewer->dataApi->getdataList();

/** Access Product API  */
$planviewer->productApi->getProducts();

```





