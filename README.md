#Pico Cache

Adds caching functionality to Pico CMS

##Installation

To install the Pico Cache plugin, simply download the `PicoCache.php` and put it in the plugins directory
`{picoInstallation}/plugins/`. Or git clone the repository with the directory.

##Configuration

You can change the defaults, by editing your `config.php` file.  
Defaults:  
```
$config['PicoCache'] = array(
   'enabled'  => true,    //Enable PicoCache
   'cacheDir' => 'cache/',//Set cache dir relative to server root
   'cacheTime'=> 604800   //Set cache time in seconds 60*60*24*7 = 604800, seven days
);
```

##Cache clearing

To *clear the cache*, remove the files from the cache folder, or delete the whole cache folder.

##Common Pitfalls

+ Make sure the directory in which the cache directory shall be created automatically has the appropriate permissions.
+ Make sure the cache directory, if created manually, has the right permission for the server to read and write files to.
+ If your site uses multiple protocols, set the *base_url* parameter in your *config.php* to be protocol independent, like `$config['base_url'] = '//example.com';`


For more information visit [glumb.de/en/pico-cms-cache-plugin](http://glumb.de/en/pico-cms-cache-plugin)
