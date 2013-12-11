#Pico Cache

Adds caching functionality to Pico CMS

##Installation

To install the Pico Cache plugin, simply download the `pico_cache.php` and put it in the plugins directory
`{picoInstallation}/plugins/`.

##Configuration
 
You can change the defaults, by changing the first three variables in the `pico_cache.php` file.

    private $cacheDir = 'content/cache/';
    private $cacheTime = 604800; // 60*60*24*7, seven days
    private $doCache = true;

##Cache clearing

To *clear the cache*, remove the files from the cache folder, or delete the whole cache folder.


For more information visit [glumb.de/en/pico-cms-cache-plugin](http://glumb.de/pico-cms-cache-plugin)
