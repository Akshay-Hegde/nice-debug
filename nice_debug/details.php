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
class Module_Nice_debug extends Module {

	public $version = '1.0.1';
	
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
		        'en' => 'Display a nice debug panel to the side.'
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
		$this->settings('add');
		return TRUE;
	}

	// --------------------------------------------------------------------------

	public function uninstall()
	{
		$this->settings('remove');
		return TRUE;
	}

	// --------------------------------------------------------------------------

	public function settings($action, $add = array())
	{
	
		// Variables
		$return     = TRUE;
		$settings   = array();
		
		// Settings
		$settings[] = array('slug' => 'nb_jquery', 'title' => 'Enable Jquery', 'description' => 'Disable this if your frontend theme already includes the jquery library', 'default' => 'yes', 'value' => 'yes', 'type' => 'select', 'options' => 'no=Disabled|yes=Enabled', 'is_required' => 1, 'is_gui' => 1, 'module' => 'nice_debug', 'order' => 101);
		$settings[] = array('slug' => 'nb_jquery_ui', 'title' => 'Enable Jquery UI', 'description' => 'Disable this if your frontend theme already includes the jquery ui library', 'default' => 'yes', 'value' => 'yes', 'type' => 'select', 'options' => 'no=Disabled|yes=Enabled', 'is_required' => 1, 'is_gui' => 1, 'module' => 'nice_debug', 'order' => 102);
		$settings[] = array('slug' => 'nb_iframe_title', 'title' => 'Nice Debug Iframe Title', 'description' => 'Title to display for the iframe tab in the nice debug panel. (Leaving this blank will remove the iframe tab)', 'default' => 'Admin Panel', 'value' => 'Admin Panel', 'type' => 'text', 'options' => '', 'is_required' => 0, 'is_gui' => 1, 'module' => 'nice_debug', 'order' => 103);
		$settings[] = array('slug' => 'nb_iframe_location', 'title' => 'Nice Debug Iframe Location', 'description' => 'Iframe location to embed for the nice debug panel', 'default' => site_url().'admin', 'value' => site_url().'admin', 'type' => 'text', 'options' => '', 'is_required' => 0, 'is_gui' => 1, 'module' => 'nice_debug', 'order' => 104);
		$settings[] = array('slug' => 'nb_theme', 'title' => 'Nice Debug Theme', 'description' => 'Style Nice Debug with a range of pre-made themes', 'default' => 'laravel', 'value' => 'laravel', 'type' => 'select', 'options' => 'laravel=Laravel|github=Github|tnb=Tomorow Night Bright|hemisulight=Hemisu Light|hemisudark=Hemisu Dark|dark-blue=Dark Blue|dark-red=Dark Red|dark-green=Dark Green|dark-yellow=Dark Yellow|dark-pink=Dark Pink|dark-orange=Dark Orange|dark-purple=Dark Purple', 'is_required' => 1, 'is_gui' => 1, 'module' => 'nice_debug', 'order' => 105);
		// Perform
		foreach( $settings as $setting )
		{

			if( $action == 'add' )
			{
				if( ( !empty($add) AND in_array($setting['slug'], $add) ) OR empty($add) )
				{
					if( !$this->db->insert('settings', $setting) )
					{
						$return = FALSE;
					}
				}
			}
			else
			{
				if( !$this->db->delete('settings', array('slug' => $setting['slug'])) )
				{
					$return = FALSE;
				}
			}

		}
		
		return $return;	
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