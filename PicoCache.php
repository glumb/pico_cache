<?php
/**
 * Pico Cache plugin
 *
 * @author Maximilian Beck
 * @link http://glumb.de
 * @license http://opensource.org/licenses/MIT
 * @Version 1.0
 */
final class PicoCache extends AbstractPicoPlugin
{
    protected $enabled = true;
    protected $cacheDir = 'cache/';
    protected $cacheTime = 604800; // 60*60*24*7, seven days
    protected $cacheFileName;

    public function onConfigLoaded(&$config)
    {
        if (isset($config['PicoCache']['cacheDir'])) {
            // ensure cache_dir ends with '/'
            $lastchar = substr($config['PicoCache']['cacheDir'], -1);
            if ($lastchar !== '/') {
                $config['PicoCache']['cacheDir'] = $config['PicoCache']['cacheDir'].'/';
            }
            $this->cacheDir = $config['PicoCache']['cacheDir'];
        }
        if (isset($config['PicoCache']['cacheTime'])) {
            $this->cacheTime = $config['PicoCache']['cacheTime'];
        }
        if (isset($config['PicoCache']['enabled'])) {
            $this->enabled = $config['PicoCache']['enabled'];
        }
    }

    public function onRequestUrl(&$url)
    {
        //replace any character except numbers and digits with a '-' to form valid file names
        $this->cacheFileName = $this->cacheDir . urlencode($url) . '.html';
        //if a cached file exists and the cacheTime is not expired, load the file and exit
        if ($this->enabled && file_exists($this->cacheFileName) && (time() - filemtime($this->cacheFileName)) < $this->cacheTime) {
            header("Expires: " . gmdate("D, d M Y H:i:s", $this->cacheTime + filemtime($this->cacheFileName)) . " GMT");
            readfile($this->cacheFileName);
            die();
        }
    }

    public function on404ContentLoaded(&$rawContent)
    {
        //don't cache error pages. This prevents filling up the cache with non existent pages
        $this->enabled = false;
    }

    public function onPageRendered(&$output)
    {
        if ($this->enabled) {
            if (!is_dir($this->cacheDir)) {
                mkdir($this->cacheDir, 0755, true);
            }
            file_put_contents($this->cacheFileName, $output);
        }
    }

}
