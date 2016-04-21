<?php
/**
 * Pico Cache plugin
 *
 * @author Maximilian Beck
 * @link http://glumb.de
 * @license http://opensource.org/licenses/MIT
 * @Version 1.0
 */
final class Pico_Xcache extends AbstractPicoPlugin
{
    protected $enabled = true;
    protected $cacheDir = 'cache/';
    protected $cacheTime = 604800; // 60*60*24*7, seven days
    protected $cacheFileName;

    public function onConfigLoaded(&$config)
    {
        if (isset($config['Pico_Xcache']['cacheDir'])) {
            // ensure cache_dir ends with '/'
            $lastchar = substr($config['Pico_Xcache']['cacheDir'], -1);
            if ($lastchar !== '/') {
                $config['Pico_Xcache']['cacheDir'] = $config['Pico_Xcache']['cacheDir'].'/';
            }
            $this->cacheDir = $config['Pico_Xcache']['cacheDir'];
        }
        if (isset($config['Pico_Xcache']['cacheTime'])) {
            $this->cacheTime = $config['Pico_Xcache']['cacheTime'];
        }
        if (isset($config['Pico_Xcache']['enabled'])) {
            $this->enabled = $config['Pico_Xcache']['enabled'];
        }
    }

    public function onRequestUrl(&$url)
    {
        if ($this->enabled && $url == 'Clear_XcacheTrue'){
          $files = glob($_SERVER['DOCUMENT_ROOT'].'/'.$this->cacheDir.'./*'); // get all file names
          foreach($files as $file){ // iterate files
            if(is_file($file))
              unlink($file); // delete file
          }
        }
        //replace any character except numbers and digits with a '-' to form valid file names
        $this->cacheFileName = $this->cacheDir . crc32($url) . '.html';
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
        if ($this->enabled && $_SERVER['REQUEST_URI'] != '/Clear_XcacheTrue' ) {
            if (!is_dir($this->cacheDir)) {
                mkdir($this->cacheDir, 0755, true);
            }
            file_put_contents($this->cacheFileName, $output);
        }
    }

}
