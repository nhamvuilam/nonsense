<?php
class CommentWrite {
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
            $instance[$key] = new CommentWrite($options);
        } // if
        return $instance[$key];
    }

// getInstance

    private function CommentWrite($options) {
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
        $this->client = new CommentWriteServiceClient($this->protocol);
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

    public function removeComment($objectId, $commentId, $userId, $clientIP) {
        try {
            $this->openTransport();
            $this->client->removeComment($objectId, $commentId, $userId, $clientIP);
            return TRUE;
        } catch (Exception $e) {
            $this->closeTransport();
            return FALSE;
        }
    }

    public function removeCommentByAdmin($objectId, $commentId, $clientIP) {
        try {
            $this->openTransport();
            $this->client->removeCommentByAdmin($objectId, $commentId, $clientIP);
            return TRUE;
        } catch (Exception $e) {
            $this->closeTransport();
            return FALSE;
        }
    }

    public function addComment($objectId, $comment, $clientIP) {
        try {
            $this->openTransport();
            $data = $this->client->addComment($objectId, $comment, $clientIP);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return array();
        }
    }

    public function addCommentRelFeed($feedId, $objectId, $comment, $clientIP) {
        try {
            $this->openTransport();
            $data = $this->client->addCommentRelFeed($feedId, $objectId, $comment, $clientIP);
            return $data;
        } catch (Exception $e) {
            $this->closeTransport();
            return FALSE;
        }
    }

    public function removeCommentRelFeed($feedId, $objectId, $commentId, $userId, $clientIP) {
        try {
            $this->openTransport();
            $this->client->removeCommentRelFeed($feedId, $objectId, $commentId, $userId, $clientIP);
            return TRUE;
        } catch (Exception $e) {
            $this->closeTransport();
            return FALSE;
        }
    }

    public function removeCommentByAdminRelFeed($feedId, $objectId, $commentId, $clientIP) {
        try {
            $this->openTransport();
            $this->client->removeCommentByAdminRelFeed($feedId, $objectId, $commentId, $clientIP);
            return TRUE;
        } catch (Exception $e) {
            $this->closeTransport();
            return FALSE;
        }
    }

}
