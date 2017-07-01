<?php

namespace RMUS\Includes;

class Core
{
    public function setup()
    {
        add_action('plugins_loaded', array($this, 'loadTextDomain'));

        $this->setupGlobals();

        $this->maybeRegisterShortcodes();

        return $this;
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain(RMUS_DOMAIN, false, dirname(plugin_basename(RMUS_FILE)).'/languages');
    }

    public function setupGlobals()
    {
        global $rmus_items;

        $rmus_items = (array) get_option('rmus_items', null);
    }

    public function maybeRegisterShortcodes()
    {
        global $rmus_items;

        if ( !$rmus_items )
            return;

        $fakeHandle = apply_filters('rmus_handler', '__return_null');

        foreach ( (array) $rmus_items as $shortcode ) {
            add_shortcode($shortcode, $fakeHandle);
        }
    }
}