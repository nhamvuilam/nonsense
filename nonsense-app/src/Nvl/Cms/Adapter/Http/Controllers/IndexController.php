<?php
namespace Nvl\Cms\Adapter\Http\Controllers;

use Nvl\Cms\App;
use Nvl\Cms\Domain\Model\Post\PostType;

class IndexController extends BaseController {

    public function indexAction($name = "there" ) {
        $config = App::config();
        var_dump($config);

        var_dump($config['cms']['db']['mongo']['username']);
        /*
        App::postApplicationService()->newPost('Hài lắm', PostType::IMAGE_LINK(), 'http://somethign.com/a.jpg', 'quyetnm', array('nham', 'hai'));
        echo 'Document inserted';

        $news = App::postApplicationService()->latestOfTag('nham', null, null);
        foreach ($news as $new) {
            var_dump($new);
        }
        */
        exit;
        echo "<h1>Hello!</h1>";
    }

}
