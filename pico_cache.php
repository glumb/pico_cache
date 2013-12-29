<?php

/**
 * Pico Cache plugin
 *
 * @author Maximilian Beck
 * @link http://glumb.de
 * @license http://opensource.org/licenses/MIT
 * @Version 1.0
 */
class Pico_Cache
{

    private $cacheDir = 'content/cache/';
    private $cacheTime = 604800; // 60*60*24*7, seven days
    private $doCache = true;
    private $cacheFileName;

    public function config_loaded(&$settings)
    {
        if (isset($settings['cache_dir'])) {
            // ensure cache_dir ends with '/'
            $lastchar = substr($settings['cache_dir'], -1);
            if ($lastchar !== '/') {
                $settings['cache_dir'] = $settings['cache_dir'].'/';
            }
            $this->cacheDir = $settings['cache_dir'];
        }
        if (isset($settings['cache_time'])) {
            $this->cacheTime = $settings['cache_time'];
        }
        if (isset($settings['cache_enabled'])) {
            $this->doCache = $settings['cache_enabled'];
        }
    }

    public function request_url(&$url)
    {
        //replace any character except numbers and digits with a '-' to form valid file names
        $this->cacheFileName = $this->cacheDir . preg_replace('/[^A-Za-z0-9_\-]/', '_', $url) . '.html';

        //if a cached file exists and the cacheTime is not expired, load the file and exit
        if ($this->doCache && file_exists($this->cacheFileName) && (time() - filemtime($this->cacheFileName)) < $this->cacheTime) {
            header("Expires: " . gmdate("D, d M Y H:i:s", $this->cacheTime + filemtime($this->cacheFileName)) . " GMT");
            readfile($this->cacheFileName);
            die();
        }
    }

    public function after_404_load_content(&$file, &$content)
    {
        //don't cache error pages. This prevents filling up the cache with non existent pages
        $this->doCache = false;
    }

    public function after_render(&$output)
    {
        if ($this->doCache) {
            if (!is_dir($this->cacheDir)) {
                mkdir($this->cacheDir, 0755, true);
            }
            file_put_contents($this->cacheFileName, $output);
        }
    }

}
