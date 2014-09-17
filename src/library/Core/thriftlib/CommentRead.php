<?php
class CommentRead {
    private $_host = 'localhost';
    private $_port = 9000;
    private $_sendTimeOut = 100;
    private $_recvTimeOut = 4000;
    private $socket = null;
    private $transport = null;
    private $protocol = null;
    private $client = null;
    public static function getInstance($options) {
        if (!is_array($options)) {
            throw new Exception('Error found in configuration !!!');
        }

        static $instance;
        $host = 'localhost';
        $port = 9000;

        if (array_key_exists('host', $options)) {
            $host = $options['host'];
        }
        if (array_key_exists('port', $options)) {
            $port = $options['port'];
        }

        $key = "$host:$port";
        if (!isset($instance[$key])) {
            $instance[$key] = new CommentRead($options);
        } // if
        return $instance[$key];
    }

// getInstance

    private function CommentRead($options) {
        if (!is_array($options)) {
            throw new Exception('Error found in configuration !!!');
        }
        if (array_key_exists('host', $options)) {
            $this->_host = $options['host'];
        }
        if (array_key_exists('port', $options)) {
            $this->_port = $options['port'];
        }
        if (array_key_exists('sendTimeOut', $options)) {
            $this->_sendTimeOut = $options['sendTimeOut'];
        }
        if (array_key_exists('recvTimeOut', $options)) {
            $this->_recvTimeOut = $options['recvTimeOut'];
        }
        $this->socket = new TSocket($this->_host, $this->_port, true);
        $this->socket->setSendTimeout($this->_sendTimeOut);
        $this->socket->setRecvTimeout($this->_recvTimeOut);
        $this->transport = new TFramedTransport($this->socket);
        $this->protocol = new TBinaryProtocolAccelerated($this->transport);
        $this->client = new CommentReadServiceClient($this->protocol);
    }

    function __destruct() {
        $this->transport->close();
    }

    private function closeTransport() {
        if ($this->transport->isOpen()) {
            $this->transport->close();
        }
    }

    private function openTransport() {
        if (!$this->transport->isOpen()) {
            $this->transport->open();
        }
    }

    public function getComment($objectId, $pageNumber, $count) {
        try {
            $this->openTransport();
            $data = $this->client->getComment($objectId, $pageNumber, $count);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return array();
        }
    }

    public function getCommentReverseOrder($objectId, $pageNumber, $count) {
        try {
            $this->openTransport();
            $data = $this->client->getCommentReverseOrder($objectId, $pageNumber, $count);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return array();
        }
    }

    public function getCommentNewer($objectId, $commentId, $count){
        try {
            $this->openTransport();
            $data = $this->client->getCommentNewer($objectId, $commentId, $count);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return array();
        }
    }

    public function getCommentOlder($objectId, $commentId, $count) {
        try {
            $this->openTransport();
            $data = $this->client->getCommentOlder($objectId, $commentId, $count);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return array();
        }
    }

    public function getCommentById($objectId, $commentId) {
        try {
            $this->openTransport();
            $data = $this->client->getCommentById($objectId, $commentId);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return array();
        }
    }

}
