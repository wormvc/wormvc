<?php
namespace MyPlugin\Sci\Assets;

defined('WPINC') OR exit('No direct script access allowed');

use Exception;
use MyPlugin\Sci\Asset;
use MyPlugin\Sci\Manager\ScriptManager;

/**
 * Asset
 *
 * @author		Eduardo Lazaro Rodriguez <me@mcme.com>
 * @author		Kenodo LTD <info@kenodo.com>
 * @copyright	2020 Kenodo LTD
 * @license		http://opensource.org/licenses/MIT	MIT License
 * @version     1.0.0
 * @link		https://www.Sci.com 
 * @since		Version 1.0.0 
 */
 
class Script extends Asset
{
    /** @var boolean $footer If the script should be added in footer/header  */
    protected $footer;
    
    /** @var ScriptManager $scriptManager The Script Manager */
	protected $scriptManager;

    /**
     * Create a new Script
     * 
     * @param string $handle The script handle
     * @param string $src The script location
     * @param string $version The script asset version
     * @param string[]  $dependences The registered script dependences
     * @param string $footer Script location
     */
    public function __construct($src,  $version = false, $dependences = [], $footer = true)
    {
        parent::__construct($src, $version, $dependences);
        $this->scriptManager = $this->sci::make(ScriptManager::class);
        $this->footer = $footer;
    }

	/**
	 * Add a new script
	 *
     * @param string $src The script location
     * @param string $version The script version
     * @param string[]  $dependences The registered script dependences
     * @param string $zone The script zone
     * @param string $footer Script location
	 * @return MyPlugin\Sci\Assets\Script
	 */
    public static function create($src,  $version = false, $dependences = [],  $footer = true)
    {
        $script = new self($src, $version, $dependences, $footer);
        return  $script;
    }

    /**
     * Add the script to the Script Manager
     * 
     * @param string $handle The script handle
     * @param string $zone Frontend or admin panel
     * @return MyPlugin\Sci\Assets\Script
     */
    public function register($handle, $zone = false)
    {
        $this->scriptManager->register($this, $handle, $zone);
        return $this;
    }

    /**
     * Returns if the asset should be placed in footer or in header
     *
     * @return boolean
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Sets if the asset should be placed in footer (true) or in header (false)
     * 
     * @param boolean $footer The boolen value
     * @return MyPlugin\Sci\Assets\Script
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }
}