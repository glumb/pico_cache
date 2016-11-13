#Pico Cache

Adds caching functionality to Pico CMS

##Installation

To install the Pico Cache plugin, simply download the `pico_xcache.php` and put it in the plugins directory
`{picoInstallation}/plugins/`.

##Configuration
 
You can change the defaults, by editing your `config.php` file.
```php
$config['cache_enabled'] = true; // default
$config['cache_dir'] = 'content/cache/'; // default
$config['cache_time'] = '604800'; // 60*60*24*7, seven days (default)
```
##Cache clearing

To *clear the cache*, remove the files from the cache folder, or delete the whole cache folder.

##Common Pitfalls

+ Make sure the directory in which the cache directory shall be created automatically has the appropriate permissions.
+ Make sure the cache directory, if created manually, has the right permission for the server to read and write files to.
+ If your site uses multiple protocols, set the *base_url* parameter in your *config.php* to be protocol independent, like `$config['base_url'] = '//example.com';`


For more information visit [glumb.de/en/pico-cms-cache-plugin](http://glumb.de/en/pico-cms-cache-plugin)
