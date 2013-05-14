<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Nice_debug
{

    protected $ci;

    public function __construct()
    {

        $this->ci =& get_instance();

        if (! $this->ci->input->is_ajax_request()) {
            // register the events
            Events::register('public_controller', array($this, 'public_controller'));
            Events::register('admin_controller', array($this, 'admin_controller'));
        }

    }

    public function public_controller()
    {
        // append jquery library if not already included
        if ($this->ci->settings->get('nb_jquery') == "yes") {
            $this->ci->template->append_metadata("<script src='//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>");
        }

        // append jquery ui library if not already included
        if ($this->ci->settings->get('nb_jquery_ui') == "yes") {
            $this->ci->template->append_metadata("<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js'></script>");
        }

        $this->enable_nice_debug();
    }

    public function admin_controller()
    {
         $this->enable_nice_debug();
    }


    public function enable_nice_debug()
    {
        // admin only accounts
        if ((isset($this->ci->current_user->group) AND $this->ci->current_user->group == 'admin')) {
            $dir = ADDONPATH.'/modules/';
            if ( file_exists(SHARED_ADDONPATH.'modules/nice_debug/details.php') ) {
                $dir = SHARED_ADDONPATH.'modules/';
            }
            Asset::add_path('nice_debug', $dir . 'nice_debug/');

            // add iframe (if enabled)
            if ($this->ci->settings->get('nb_iframe_title')) {
                $this->ci->template->append_metadata("<script> var isInIframe = (window.location != window.parent.location) ? true : false; function add_nb_iframe(){ if (! isInIframe) { $('#log-padding').append(\"<span class='h3'>".$this->ci->settings->get('nb_iframe_title')."</span><div class='pln'><iframe class='nice_debug_frame' src='".$this->ci->settings->get('nb_iframe_location')."' id='adminFrame'/></div>\"); } } </script>");
            }

            // append hover intent and easing
            $this->ci->template->append_js("nice_debug::hover-intent.js");
            $this->ci->template->append_js("nice_debug::easing.js");

            // append nice debug css and js
            $this->ci->template->append_css("nice_debug::nice_debug.css");
            $this->ci->template->append_js("nice_debug::nice_debug.js");

            // append theme
            $this->ci->template->append_css("nice_debug::".$this->ci->settings->get('nb_theme').".css");

            // append google prettify js
            $this->ci->template->append_js("nice_debug::prettify.js");

            // append cookie to remember if nice debug is open or closed
            $this->ci->template->append_js("nice_debug::jquery.cookie.js");

            // enable profiler
            $this->ci->output->enable_profiler(TRUE);
        }
    }

}
