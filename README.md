#Pico Cache

Adds caching functionality to Pico CMS

##Installation

To install the Pico Cache plugin, simply download the `pico_cache.php` and put it in the plugins directory
`{picoInstallation}/plugins/`.

##Configuration
 
You can change the defaults, by editing your `config.php` file.

    $config['cache_enabled'] = true; // default
    $config['cache_dir'] = 'content/cache/'; // default
    $config['cache_time'] = '604800'; // 60*60*24*7, seven days (default)

##Cache clearing

To *clear the cache*, remove the files from the cache folder, or delete the whole cache folder.


For more information visit [glumb.de/en/pico-cms-cache-plugin](http://glumb.de/en/pico-cms-cache-plugin)
