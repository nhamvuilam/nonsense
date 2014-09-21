<?php
namespace Nvl\Content\Adapter\Http\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Base controller extends Phalcon Controller, provides basic methods for a controller
 * and helps isolating controller code from the MVC Framework in-use.
 * @author qunguyen
 */
class BaseController extends Controller {

    function isPost() {
        return $this->request->isPost();
    }

    function isGet() {
        return $this->request->isGet();
    }

    function isPut() {
        return $this->request->isPut();
    }

    function isDelete() {
        return $this->request->isDelete();
    }

    function isPatch() {
        return $this->request->isPatch();
    }

    function isHead() {
        return $this->request->isHead();
    }

    function isMethod($methods) {
        return $this->request->isMethod($methods);
    }

    function isAjax() {
        return $this->request->isAjax();
    }

    function getRequestUri() {
    	return $this->request->getURI();
    }

    function getUserAgent() {
        return $this->request->getUserAgent();
    }

    public function getRawBody() {
    	return $this->request->getRawBody();
    }

    public function getServerAddress() {
    	return $this->request->getServerAddress();
    }

    public function isSoapRequested() {
        return $this->isSoapRequested();
    }

    public function isSecureRequest() {
        return $this->isSecureRequest();
    }

    public function getJsonRawBody() {
    	return $this->request->getJsonRawBody();
    }

    function hasFiles($notErrored=null){
    	return $this->request->hasFiles($notErrored);
    }

    function getUploadedFiles($notErrored=null){
    	return $this->request->getUploadedFiles($notErrored);
    }

    function getHeader($headerName) {
        return $this->request->getHeader($headerName);
    }

    function getHeaders(){
    	return $this->request->getHeaders();
    }

    function getReferer(){
    	return $this->request->getHTTPReferer();
    }

    function getPostParam($name, $default = null) {
        return $this->request->getPost($name, null, $default);
    }

    function getGetParam($name, $default = null) {
        return $this->request->getQuery($name, null, $default);
    }

    function getPutParam($name, $default = null) {
        return $this->request->getPut($name, null, $default);
    }

    /**
     * Foward to a controller
     *
     * @param $to Destination to forward
     */
    function forward($controller, $action) {
        $this->dispatcher->forward(array(
        	'controller' => $controller,
            'action'     => $action,
        ));
    }

    /**
     * Redirect to an url
     *
     * @param $url The url to redirect to
     */
    function redirect($url) {
        header('Location: '.$url);
        exit;
    }

}