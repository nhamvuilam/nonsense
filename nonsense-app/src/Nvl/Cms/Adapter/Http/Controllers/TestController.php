<?php
namespace Nvl\Cms\Adapter\Http\Controllers;

use Nvl\Cms\App;

class TestController extends BaseController {

    function newPostAction() {
        $post = App::postApplicationService()->newPost(
                'image',
                array('meme', 'hot'),
                null,
                array(
            	   // 'link' => 'http://img-9gag-lol.9cache.com/photo/a0PKyBq_460s.jpg',
            	   'link' => 'http://s2.haivl.com/data/photos2/20140929/e8087aa88d2a4133874193e41f485bba/medium-96e421f2cfbf47ab927fc3386496612c-650.jpg',
            	   // 'link' => '/Users/qunguyen/Pictures/Background/03717_wintertime_2880x1800.jpg',
                   'data' => null,
            	   'caption' => 'Có thánh nào bị như em không',
                )
        );
        echo '<h1>Document inserted</h1>';
        var_dump($post);
        exit;
    }
}