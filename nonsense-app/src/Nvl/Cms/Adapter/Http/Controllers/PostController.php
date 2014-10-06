<?php
namespace Nvl\Cms\Adapter\Http\Controllers;
use Nvl\Cms\App;
class PostController extends BaseController {

	public function initialize()
    {
        $this->view->setLayout('main');
    }

    public function indexAction() {
        // HTTP Method: Post
        if ($this->isPost()) {

			$params = $this->getPostParam();
			$arrContent = array();

        	//Check if the user has uploaded files (image)
            if ($this->request->hasFiles() == true) {

                //get file upload into upload folder
                foreach ($this->request->getUploadedFiles() as $file) {
                	$arrContent['data'][] = array(
                		'uploaded_path' => $file->getTempName(), 'name' => $file->getName(),
                		'type' => $file->getRealType()
					);
                }

				$arrContent['caption'] = $params['title'];
				$arrContent['type'] = 'image';

            } else { // type is Video

            	$arrContent['type'] = 'image';
            	$arrContent['link'] = $params['url'];
				$arrContent['caption'] = $params['title'];
            }

			$result = App::postApplicationService()->newPost(
                    $arrContent['type'],
			        '',
			        time(),
			        $arrContent,
			        array(
			            'source_url' => @$params['source_url']
                    ));

			$this->redirect("/");

        }

    }

}
