<?php

namespace RMUS\Includes;

use RMUS\Admin\Admin;

class Setup
{
    protected $core, $admin;

    public function __construct($first_instance=null)
    {
        $this->core = new Core;
        $this->admin = new Admin;

        if ( $first_instance ) {
            $this->setup();
        }
    }

    private function setup()
    {
        $this->core->setup();

        if ( is_admin() ) {
            $this->admin->setup();
        }

        return $this;
    }
}