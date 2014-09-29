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
                foreach ($this->request->getUploadedFiles() as $file){
                	echo $file->getName();                    		
            		//$file->moveTo(APP_DIR.'/caches/upload/' . $file->getName());                            
                }
								
				$arrContent['link'] = $file->getName();
				$arrContent['data'] = $file->getName();
				$arrContent['caption'] = $params['title'];
															
            } else { // type is link
            	
            	$arrContent['embeded'] = $params['url'];				
				$arrContent['caption'] = $params['title'];
            }						
						
			$result = App::postApplicationService()->newPost(
				$params['type'], '', time(), $arrContent);
						            
			if ($result == 1) {	// insert success	        			
				$this->redirect("/");
			}  
			
			$this->redirect("/post");			
            
        }
		                
    }

}
