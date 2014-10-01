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
                		'uploaded_path' => $file->getPath(), 'name' => $file->getName(),
                		'type' => $file->getRealType()
					);             		                         
                }
															
				$arrContent['caption'] = $params['title'];
				$arrContent['type'] = 'image';
															
            } else { // type is link
            
            	$arrContent['type'] = 'video';
            	$arrContent['embedded'] = $params['url'];				
				$arrContent['caption'] = $params['title'];				
            }															
						
			$result = App::postApplicationService()->newPost(
				$arrContent['type'], '', time(), $arrContent);
						            			        		
			$this->redirect("/");					
            
        }
		                
    }

}
