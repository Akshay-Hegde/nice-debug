<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Nice_debug
{

    protected $ci;

    public function __construct()
    {

        $this->ci =& get_instance();

        // register the events
        Events::register('public_controller', array($this, 'public_controller'));
        Events::register('admin_controller', array($this, 'public_controller'));

    }

    public function public_controller()
    {

        if ((isset($this->ci->current_user->group) AND $this->ci->current_user->group == 'admin')) {
            $dir = ADDONPATH.'/modules/';
            if ( file_exists(SHARED_ADDONPATH.'modules/nice_debug/details.php') ) {
                $dir = SHARED_ADDONPATH.'modules/';
            }
            Asset::add_path('nice_debug', $dir . 'nice_debug/');

            //append nice debug css and js
            $this->ci->template->append_css("nice_debug::nice_debug.css");
            $this->ci->template->append_js("nice_debug::nice_debug.js");
            //append google prettify css and js (select only one css file at a time)
            $this->ci->template->append_css("nice_debug::github.css");
            //$this->ci->template->append_css("nice_debug::laravel.css");
            //$this->ci->template->append_css("nice_debug::hemisu-light.css");
            //$this->ci->template->append_css("nice_debug::hemisu-dark.css");
            //$this->ci->template->append_css("nice_debug::tomorrow-night-bright.css");
            $this->ci->template->append_js("nice_debug::prettify.js");
            //enable profiler
            $this->ci->output->enable_profiler(TRUE);
        }
    }

}
