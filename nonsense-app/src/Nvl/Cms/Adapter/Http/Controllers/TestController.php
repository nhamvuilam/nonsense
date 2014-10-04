<?php
namespace Nvl\Cms\Adapter\Http\Controllers;

use Nvl\Cms\App;
use Nvl\Cms\Domain\Model\User\AuthenticationException;

class TestController extends BaseController {

    function newPostAction() {
        $post = App::postApplicationService()->newPost(
                'image',
                array('meme', 'hot'),
                null,
                array(
            	   // 'link' => 'http://img-9gag-lol.9cache.com/photo/a0PKyBq_460s.jpg',
            	   'link' => 'http://s2.haivl.com/data/photos2/20140929/e8087aa88d2a4133874193e41f485bba/medium-96e421f2cfbf47ab927fc3386496612c-650.jpg',

                   // Upload
//             	   'data' => array(array(
//             	       'uploaded_path' => '/Users/qunguyen/Pictures/1069842_297934583686135_1157348677_n.jpg',
//                        'name'          => 'filename',
//             	       'type'          => 'image/jpeg',
//             	   )),
                   'data' => null,

            	   'caption' => 'Có thánh nào bị như em không',
                )
        );
        echo '<h1>Document inserted</h1>';
        echo $post->html();
        var_dump($post->toArray());
        exit;
    }

    function newVideoPostAction() {

        $post = App::postApplicationService()->newPost(
            'video',
            array('anim', 'video'),
            null,
            array(
                'caption'  => 'Legend of Korra',
                'link'     => 'http://www.youtube.com/watch?v=NCEFMY4TWGw',
            )
        );

        echo '<h1>Document inserted</h1>';
        echo $post->html(array());
        var_dump($post->toArray());
        exit;
    }

    function queryPostAction() {
        echo '<h1>By tags</h1>';
        $posts = App::postApplicationService()->queryPosts(array(), '', array(), 10, 0);
        var_dump($posts);
        exit;
    }

    function newUserAction() {
        $id = uniqid('minhquyet');
        echo '<h1>New Password Login</h1>';
        $user = App::userApplicationService()->register($id.'@gmail.com', '123456', 'Quyet', 'minhquyet@gmail.com', null);
        echo '<br>Persisted!!!';
        var_dump($user);

        echo '<h1>Fail Login</h1>';
        try {
            $failUser= App::userApplicationService()->authenticate($id.'@gmail.com', '1123456');
        } catch (AuthenticationException $e) {
            echo '<p>'.$e->getMessage();
        }
        echo '<br>Returned user:';
        var_dump($failUser);

        echo '<h1>Login</h1>';
        try {
            $succeedUser = App::userApplicationService()->authenticate($id.'@gmail.com', '123456');
        } catch (AuthenticationException $e) {
            echo '<p>'.$e->getMessage();
        }
        echo '<br>Returned user:';
        var_dump($succeedUser);

        exit;
    }
}