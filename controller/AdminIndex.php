<?php

namespace tiny_cms\controller;

use atomar\core\Auth;
use atomar\core\Controller;
use atomar\core\Templator;
use tiny_cms\TinyCMS;

class AdminIndex extends Controller {
    function GET($matches = array()) {
        Auth::authenticate('administer_tiny_cms');
        Templator::$css[] = '/assets/tiny_cms/css/style.css';
        // render page
        $stubs = TinyCMS::get_all_stubs();

        echo $this->renderView('@tiny_cms/views/admin.index.html', array(
            'stubs' => $stubs
        ));
    }

    function POST($matches = array()) {
        $this->go('/admin/tiny_cms');
    }
}