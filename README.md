
# Planviewer API Client


# Install Composer
curl -sS https://getcomposer.org/installer | php

# Install dependencies
composer.phar install


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




