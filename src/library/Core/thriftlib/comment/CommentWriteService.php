<?php

interface CommentWriteServiceIf {
  public function removeComment($objectId, $commentId, $userId, $clientIP);
  public function removeCommentByAdmin($objectId, $commentId, $clientIP);
  public function addComment($objectId, $comment, $clientIP);
  public function addCommentRelFeed($feedId, $objectId, $comment, $clientIP);
  public function removeCommentRelFeed($feedId, $objectId, $commentId, $userId, $clientIP);
  public function removeCommentByAdminRelFeed($feedId, $objectId, $commentId, $clientIP);
}

class CommentWriteServiceClient implements CommentWriteServiceIf {
  protected $input_ = null;
  protected $output_ = null;

  protected $seqid_ = 0;

  public function __construct($input, $output=null) {
    $this->input_ = $input;
    $this->output_ = $output ? $output : $input;
  }

  public function removeComment($objectId, $commentId, $userId, $clientIP)
  {
    $this->send_removeComment($objectId, $commentId, $userId, $clientIP);
  }

  public function send_removeComment($objectId, $commentId, $userId, $clientIP)
  {
    $args = new comment_CommentWriteService_removeComment_args();
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $args->userId = $userId;
    $args->clientIP = $clientIP;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'removeComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('removeComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }
  public function removeCommentByAdmin($objectId, $commentId, $clientIP)
  {
    $this->send_removeCommentByAdmin($objectId, $commentId, $clientIP);
  }

  public function send_removeCommentByAdmin($objectId, $commentId, $clientIP)
  {
    $args = new comment_CommentWriteService_removeCommentByAdmin_args();
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $args->clientIP = $clientIP;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'removeCommentByAdmin', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('removeCommentByAdmin', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }
  public function addComment($objectId, $comment, $clientIP)
  {
    $this->send_addComment($objectId, $comment, $clientIP);
    return $this->recv_addComment();
  }

  public function send_addComment($objectId, $comment, $clientIP)
  {
    $args = new comment_CommentWriteService_addComment_args();
    $args->objectId = $objectId;
    $args->comment = $comment;
    $args->clientIP = $clientIP;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'addComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('addComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_addComment()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentWriteService_addComment_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new comment_CommentWriteService_addComment_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("addComment failed: unknown result");
  }

  public function addCommentRelFeed($feedId, $objectId, $comment, $clientIP)
  {
    $this->send_addCommentRelFeed($feedId, $objectId, $comment, $clientIP);
    return $this->recv_addCommentRelFeed();
  }

  public function send_addCommentRelFeed($feedId, $objectId, $comment, $clientIP)
  {
    $args = new comment_CommentWriteService_addCommentRelFeed_args();
    $args->feedId = $feedId;
    $args->objectId = $objectId;
    $args->comment = $comment;
    $args->clientIP = $clientIP;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'addCommentRelFeed', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('addCommentRelFeed', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_addCommentRelFeed()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentWriteService_addCommentRelFeed_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new comment_CommentWriteService_addCommentRelFeed_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("addCommentRelFeed failed: unknown result");
  }

  public function removeCommentRelFeed($feedId, $objectId, $commentId, $userId, $clientIP)
  {
    $this->send_removeCommentRelFeed($feedId, $objectId, $commentId, $userId, $clientIP);
  }

  public function send_removeCommentRelFeed($feedId, $objectId, $commentId, $userId, $clientIP)
  {
    $args = new comment_CommentWriteService_removeCommentRelFeed_args();
    $args->feedId = $feedId;
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $args->userId = $userId;
    $args->clientIP = $clientIP;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'removeCommentRelFeed', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('removeCommentRelFeed', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }
  public function removeCommentByAdminRelFeed($feedId, $objectId, $commentId, $clientIP)
  {
    $this->send_removeCommentByAdminRelFeed($feedId, $objectId, $commentId, $clientIP);
  }

  public function send_removeCommentByAdminRelFeed($feedId, $objectId, $commentId, $clientIP)
  {
    $args = new comment_CommentWriteService_removeCommentByAdminRelFeed_args();
    $args->feedId = $feedId;
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $args->clientIP = $clientIP;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'removeCommentByAdminRelFeed', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('removeCommentByAdminRelFeed', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }
}

// HELPER FUNCTIONS AND STRUCTURES

class comment_CommentWriteService_removeComment_args {
  static $_TSPEC;

  public $objectId = null;
  public $commentId = null;
  public $userId = null;
  public $clientIP = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'commentId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'userId',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'clientIP',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['commentId'])) {
        $this->commentId = $vals['commentId'];
      }
      if (isset($vals['userId'])) {
        $this->userId = $vals['userId'];
      }
      if (isset($vals['clientIP'])) {
        $this->clientIP = $vals['clientIP'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_removeComment_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->objectId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->commentId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->userId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->clientIP);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_removeComment_args');
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 1);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->commentId !== null) {
      $xfer += $output->writeFieldBegin('commentId', TType::I64, 2);
      $xfer += $output->writeI64($this->commentId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->userId !== null) {
      $xfer += $output->writeFieldBegin('userId', TType::I32, 3);
      $xfer += $output->writeI32($this->userId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->clientIP !== null) {
      $xfer += $output->writeFieldBegin('clientIP', TType::STRING, 4);
      $xfer += $output->writeString($this->clientIP);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_removeCommentByAdmin_args {
  static $_TSPEC;

  public $objectId = null;
  public $commentId = null;
  public $clientIP = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'commentId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'clientIP',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['commentId'])) {
        $this->commentId = $vals['commentId'];
      }
      if (isset($vals['clientIP'])) {
        $this->clientIP = $vals['clientIP'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_removeCommentByAdmin_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->objectId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->commentId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->clientIP);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_removeCommentByAdmin_args');
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 1);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->commentId !== null) {
      $xfer += $output->writeFieldBegin('commentId', TType::I64, 2);
      $xfer += $output->writeI64($this->commentId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->clientIP !== null) {
      $xfer += $output->writeFieldBegin('clientIP', TType::STRING, 3);
      $xfer += $output->writeString($this->clientIP);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_addComment_args {
  static $_TSPEC;

  public $objectId = null;
  public $comment = null;
  public $clientIP = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'comment',
          'type' => TType::STRUCT,
          'class' => 'comment_Comment',
          ),
        3 => array(
          'var' => 'clientIP',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['comment'])) {
        $this->comment = $vals['comment'];
      }
      if (isset($vals['clientIP'])) {
        $this->clientIP = $vals['clientIP'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_addComment_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->objectId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRUCT) {
            $this->comment = new comment_Comment();
            $xfer += $this->comment->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->clientIP);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_addComment_args');
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 1);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->comment !== null) {
      if (!is_object($this->comment)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('comment', TType::STRUCT, 2);
      $xfer += $this->comment->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->clientIP !== null) {
      $xfer += $output->writeFieldBegin('clientIP', TType::STRING, 3);
      $xfer += $output->writeString($this->clientIP);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_addComment_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_Result',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_addComment_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::STRUCT) {
            $this->success = new comment_Result();
            $xfer += $this->success->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_addComment_result');
    if ($this->success !== null) {
      if (!is_object($this->success)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('success', TType::STRUCT, 0);
      $xfer += $this->success->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_addCommentRelFeed_args {
  static $_TSPEC;

  public $feedId = null;
  public $objectId = null;
  public $comment = null;
  public $clientIP = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'feedId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'comment',
          'type' => TType::STRUCT,
          'class' => 'comment_Comment',
          ),
        4 => array(
          'var' => 'clientIP',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['feedId'])) {
        $this->feedId = $vals['feedId'];
      }
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['comment'])) {
        $this->comment = $vals['comment'];
      }
      if (isset($vals['clientIP'])) {
        $this->clientIP = $vals['clientIP'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_addCommentRelFeed_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->feedId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->objectId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRUCT) {
            $this->comment = new comment_Comment();
            $xfer += $this->comment->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->clientIP);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_addCommentRelFeed_args');
    if ($this->feedId !== null) {
      $xfer += $output->writeFieldBegin('feedId', TType::I64, 1);
      $xfer += $output->writeI64($this->feedId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 2);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->comment !== null) {
      if (!is_object($this->comment)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('comment', TType::STRUCT, 3);
      $xfer += $this->comment->write($output);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->clientIP !== null) {
      $xfer += $output->writeFieldBegin('clientIP', TType::STRING, 4);
      $xfer += $output->writeString($this->clientIP);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_addCommentRelFeed_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_Result',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_addCommentRelFeed_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::STRUCT) {
            $this->success = new comment_Result();
            $xfer += $this->success->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_addCommentRelFeed_result');
    if ($this->success !== null) {
      if (!is_object($this->success)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('success', TType::STRUCT, 0);
      $xfer += $this->success->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_removeCommentRelFeed_args {
  static $_TSPEC;

  public $feedId = null;
  public $objectId = null;
  public $commentId = null;
  public $userId = null;
  public $clientIP = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'feedId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'commentId',
          'type' => TType::I64,
          ),
        4 => array(
          'var' => 'userId',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'clientIP',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['feedId'])) {
        $this->feedId = $vals['feedId'];
      }
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['commentId'])) {
        $this->commentId = $vals['commentId'];
      }
      if (isset($vals['userId'])) {
        $this->userId = $vals['userId'];
      }
      if (isset($vals['clientIP'])) {
        $this->clientIP = $vals['clientIP'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_removeCommentRelFeed_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->feedId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->objectId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->commentId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->userId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->clientIP);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_removeCommentRelFeed_args');
    if ($this->feedId !== null) {
      $xfer += $output->writeFieldBegin('feedId', TType::I64, 1);
      $xfer += $output->writeI64($this->feedId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 2);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->commentId !== null) {
      $xfer += $output->writeFieldBegin('commentId', TType::I64, 3);
      $xfer += $output->writeI64($this->commentId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->userId !== null) {
      $xfer += $output->writeFieldBegin('userId', TType::I32, 4);
      $xfer += $output->writeI32($this->userId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->clientIP !== null) {
      $xfer += $output->writeFieldBegin('clientIP', TType::STRING, 5);
      $xfer += $output->writeString($this->clientIP);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentWriteService_removeCommentByAdminRelFeed_args {
  static $_TSPEC;

  public $feedId = null;
  public $objectId = null;
  public $commentId = null;
  public $clientIP = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'feedId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'commentId',
          'type' => TType::I64,
          ),
        4 => array(
          'var' => 'clientIP',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['feedId'])) {
        $this->feedId = $vals['feedId'];
      }
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['commentId'])) {
        $this->commentId = $vals['commentId'];
      }
      if (isset($vals['clientIP'])) {
        $this->clientIP = $vals['clientIP'];
      }
    }
  }

  public function getName() {
    return 'CommentWriteService_removeCommentByAdminRelFeed_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->feedId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->objectId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->commentId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->clientIP);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('CommentWriteService_removeCommentByAdminRelFeed_args');
    if ($this->feedId !== null) {
      $xfer += $output->writeFieldBegin('feedId', TType::I64, 1);
      $xfer += $output->writeI64($this->feedId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 2);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->commentId !== null) {
      $xfer += $output->writeFieldBegin('commentId', TType::I64, 3);
      $xfer += $output->writeI64($this->commentId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->clientIP !== null) {
      $xfer += $output->writeFieldBegin('clientIP', TType::STRING, 4);
      $xfer += $output->writeString($this->clientIP);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

?>
