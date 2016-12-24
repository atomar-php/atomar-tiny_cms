<?php

namespace cms_light\controller;

use atomic\core\Auth;
use atomic\core\Controller;
use atomic\core\Templator;
use cms_light\CmsLightAPI;

class AdminIndex extends Controller {
    function GET($matches = array()) {
        Auth::authenticate('administer_cms_light');
        Templator::$css[] = '/includes/extensions/cms_light/css/style.css';
        // render page
        $stubs = CmsLightAPI::get_all_stubs();

        echo $this->render_view('cms_light/views/admin.index.html', array(
            'stubs' => $stubs
        ));
    }

    function POST($matches = array()) {
        $this->go('/admin/cms_light');
    }
}