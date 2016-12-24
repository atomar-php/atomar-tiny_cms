<?php

namespace cms_light\controller;

use atomic\core\Auth;
use atomic\core\Lightbox;
use atomic\core\Templator;
use cms_light\CmsLightAPI;

class AdminStubNew extends Lightbox {
    function GET($matches = array()) {
        if (!Auth::has_authentication('administer_cms_light')) {
            set_error('You are not authorized to administer CMSLight');
            $this->redirect('/');
        }

        Templator::$js_onload[] = <<<JS
$('[data-validate]').each(function() {
  var v = new Validate($(this));
});
$('#field-name').change(function() {
  var value = human_to_machine($(this).val());
  $('#field-slug').val(value);
}).keyup( function () {
  $(this).change();
});
JS;
        Templator::$css_inline[] = <<<CSS
#slug {
      margin: 30px 0 0 10px;
    }
CSS;
        // configure lightbox
        $this->height(380);
        $this->width(500);
        $this->header('New Stub');

        echo $this->render_view('cms_light/views/modal.stub.new.html');
    }

    function POST($matches = array()) {
        if (!Auth::has_authentication('administer_cms_light')) {
            set_error('You are not authorized to administer CMSLight');
            $this->redirect('/');
        }

        $result = CmsLightAPI::define_stub($_REQUEST['name'], $_REQUEST['text']);
        if ($result) {
            set_success('Stub successfully created');
        } else {
            set_error('The stub could not be created');
        }
        $this->redirect('/admin/cms_light/');
    }

    /**
     * This method will be called before GET, POST, and PUT when the lightbox is returned to e.g. when using lightbox.dismiss_url or lightbox.return_url
     */
    function RETURNED() {
        // TODO: Implement RETURNED() method.
    }
}