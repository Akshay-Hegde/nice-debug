<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Nice Debug Module
 *
 * @package		PyroCMS
 * @subpackage	Nice Debug
 * @category	events
 * @author		Adam Sturrock
 * @link 		http://www.adamsturrock.co.uk/
 */
class Module_Nice_debug extends Module
{
    public $version = '1.0.0';

    public $db_pre;

     // --------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------------

     public function info()
    {
        return array(
            'name' => array(
                'en' => 'Nice Debug'
            ),
            'description' => array(
                'en' => 'Display a nice debug panel on the left hand side of every page (admin accounts only).'
            ),
            'frontend' => false,
            'backend' => false,
            'skip_xss' => true,
            'author' => 'Adam Sturrock'
        );
    }

    // --------------------------------------------------------------------------

    public function install()
    {
        return TRUE;
    }

    // --------------------------------------------------------------------------

    public function uninstall()
    {
        return TRUE;
    }

    // --------------------------------------------------------------------------

    public function upgrade($old_version)
    {
        return TRUE;
    }

    // --------------------------------------------------------------------------

    public function help()
    {
        return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
    }

}
