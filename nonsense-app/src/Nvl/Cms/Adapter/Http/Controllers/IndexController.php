<?php
namespace Nvl\Cms\Adapter\Http\Controllers;

use Nvl\Cms\App;
use Nvl\Cms\Domain\Model\Post\PostType;

class IndexController extends BaseController {

    public function indexAction($name = "there" ) {
        App::postApplicationService()->newPost(
                'image',
                 array('gai xinh', 'chay vai'),
                 null,
                 array(
                    'link' => 'http://somethign.com/a.jpg',
                    'caption' => 'Có điều gì đó không ổn trong bức ảnh này',
                 ));

        echo 'Document inserted';
        App::postApplicationService()->newPost(
                'video',
                 array('music'),
                 null,
                 array(
                    'embedded' => '<embeded />',
                    'caption' => 'Một bản nhac vượt thời gian',
                 ));

        // App::postApplicationService()->newPost('Hài lắm', PostType::IMAGE_LINK(), 'http://somethign.com/a.jpg', 'quyetnm', array('nham', 'hai'));
        echo 'Document inserted';

        /*
        $news = App::postApplicationService()->latestOfTag('nham', null, null);
        foreach ($news as $new) {
            var_dump($new);
        }
        */
        exit;
        echo "<h1>Hello!</h1>";
    }

}
