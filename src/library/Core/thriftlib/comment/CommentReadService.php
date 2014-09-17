<?php

interface CommentReadServiceIf {
  public function getComment($objectId, $pageNumber, $count);
  public function getCommentReverseOrder($objectId, $pageNumber, $count);
  public function getCommentNewer($objectId, $commentId, $count);
  public function getCommentOlder($objectId, $commentId, $count);
  public function getCommentById($objectId, $commentId);
}

class CommentReadServiceClient implements CommentReadServiceIf {
  protected $input_ = null;
  protected $output_ = null;

  protected $seqid_ = 0;

  public function __construct($input, $output=null) {
    $this->input_ = $input;
    $this->output_ = $output ? $output : $input;
  }

  public function getComment($objectId, $pageNumber, $count)
  {
    $this->send_getComment($objectId, $pageNumber, $count);
    return $this->recv_getComment();
  }

  public function send_getComment($objectId, $pageNumber, $count)
  {
    $args = new comment_CommentReadService_getComment_args();
    $args->objectId = $objectId;
    $args->pageNumber = $pageNumber;
    $args->count = $count;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getComment', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getComment', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getComment()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentReadService_getComment_result', $this->input_->isStrictRead());
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
      $result = new comment_CommentReadService_getComment_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getComment failed: unknown result");
  }

  public function getCommentReverseOrder($objectId, $pageNumber, $count)
  {
    $this->send_getCommentReverseOrder($objectId, $pageNumber, $count);
    return $this->recv_getCommentReverseOrder();
  }

  public function send_getCommentReverseOrder($objectId, $pageNumber, $count)
  {
    $args = new comment_CommentReadService_getCommentReverseOrder_args();
    $args->objectId = $objectId;
    $args->pageNumber = $pageNumber;
    $args->count = $count;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentReverseOrder', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentReverseOrder', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentReverseOrder()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentReadService_getCommentReverseOrder_result', $this->input_->isStrictRead());
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
      $result = new comment_CommentReadService_getCommentReverseOrder_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getCommentReverseOrder failed: unknown result");
  }

  public function getCommentNewer($objectId, $commentId, $count)
  {
    $this->send_getCommentNewer($objectId, $commentId, $count);
    return $this->recv_getCommentNewer();
  }

  public function send_getCommentNewer($objectId, $commentId, $count)
  {
    $args = new comment_CommentReadService_getCommentNewer_args();
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $args->count = $count;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentNewer', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentNewer', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentNewer()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentReadService_getCommentNewer_result', $this->input_->isStrictRead());
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
      $result = new comment_CommentReadService_getCommentNewer_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getCommentNewer failed: unknown result");
  }

  public function getCommentOlder($objectId, $commentId, $count)
  {
    $this->send_getCommentOlder($objectId, $commentId, $count);
    return $this->recv_getCommentOlder();
  }

  public function send_getCommentOlder($objectId, $commentId, $count)
  {
    $args = new comment_CommentReadService_getCommentOlder_args();
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $args->count = $count;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentOlder', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentOlder', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentOlder()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentReadService_getCommentOlder_result', $this->input_->isStrictRead());
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
      $result = new comment_CommentReadService_getCommentOlder_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getCommentOlder failed: unknown result");
  }

  public function getCommentById($objectId, $commentId)
  {
    $this->send_getCommentById($objectId, $commentId);
    return $this->recv_getCommentById();
  }

  public function send_getCommentById($objectId, $commentId)
  {
    $args = new comment_CommentReadService_getCommentById_args();
    $args->objectId = $objectId;
    $args->commentId = $commentId;
    $bin_accel = ($this->output_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'getCommentById', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('getCommentById', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_getCommentById()
  {
    $bin_accel = ($this->input_ instanceof TProtocol::$TBINARYPROTOCOLACCELERATED) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, 'comment_CommentReadService_getCommentById_result', $this->input_->isStrictRead());
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
      $result = new comment_CommentReadService_getCommentById_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    throw new Exception("getCommentById failed: unknown result");
  }

}

// HELPER FUNCTIONS AND STRUCTURES

class comment_CommentReadService_getComment_args {
  static $_TSPEC;

  public $objectId = null;
  public $pageNumber = null;
  public $count = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'pageNumber',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'count',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['pageNumber'])) {
        $this->pageNumber = $vals['pageNumber'];
      }
      if (isset($vals['count'])) {
        $this->count = $vals['count'];
      }
    }
  }

  public function getName() {
    return 'CommentReadService_getComment_args';
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
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->pageNumber);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->count);
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
    $xfer += $output->writeStructBegin('CommentReadService_getComment_args');
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 1);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->pageNumber !== null) {
      $xfer += $output->writeFieldBegin('pageNumber', TType::I32, 2);
      $xfer += $output->writeI32($this->pageNumber);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->count !== null) {
      $xfer += $output->writeFieldBegin('count', TType::I32, 3);
      $xfer += $output->writeI32($this->count);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentReadService_getComment_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_ObjectComment',
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
    return 'CommentReadService_getComment_result';
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
            $this->success = new comment_ObjectComment();
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
    $xfer += $output->writeStructBegin('CommentReadService_getComment_result');
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

class comment_CommentReadService_getCommentReverseOrder_args {
  static $_TSPEC;

  public $objectId = null;
  public $pageNumber = null;
  public $count = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'objectId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'pageNumber',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'count',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['pageNumber'])) {
        $this->pageNumber = $vals['pageNumber'];
      }
      if (isset($vals['count'])) {
        $this->count = $vals['count'];
      }
    }
  }

  public function getName() {
    return 'CommentReadService_getCommentReverseOrder_args';
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
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->pageNumber);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->count);
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentReverseOrder_args');
    if ($this->objectId !== null) {
      $xfer += $output->writeFieldBegin('objectId', TType::I64, 1);
      $xfer += $output->writeI64($this->objectId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->pageNumber !== null) {
      $xfer += $output->writeFieldBegin('pageNumber', TType::I32, 2);
      $xfer += $output->writeI32($this->pageNumber);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->count !== null) {
      $xfer += $output->writeFieldBegin('count', TType::I32, 3);
      $xfer += $output->writeI32($this->count);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentReadService_getCommentReverseOrder_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_ObjectComment',
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
    return 'CommentReadService_getCommentReverseOrder_result';
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
            $this->success = new comment_ObjectComment();
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentReverseOrder_result');
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

class comment_CommentReadService_getCommentNewer_args {
  static $_TSPEC;

  public $objectId = null;
  public $commentId = null;
  public $count = null;

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
          'var' => 'count',
          'type' => TType::I32,
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
      if (isset($vals['count'])) {
        $this->count = $vals['count'];
      }
    }
  }

  public function getName() {
    return 'CommentReadService_getCommentNewer_args';
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
            $xfer += $input->readI32($this->count);
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentNewer_args');
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
    if ($this->count !== null) {
      $xfer += $output->writeFieldBegin('count', TType::I32, 3);
      $xfer += $output->writeI32($this->count);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentReadService_getCommentNewer_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_ObjectComment',
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
    return 'CommentReadService_getCommentNewer_result';
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
            $this->success = new comment_ObjectComment();
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentNewer_result');
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

class comment_CommentReadService_getCommentOlder_args {
  static $_TSPEC;

  public $objectId = null;
  public $commentId = null;
  public $count = null;

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
          'var' => 'count',
          'type' => TType::I32,
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
      if (isset($vals['count'])) {
        $this->count = $vals['count'];
      }
    }
  }

  public function getName() {
    return 'CommentReadService_getCommentOlder_args';
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
            $xfer += $input->readI32($this->count);
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentOlder_args');
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
    if ($this->count !== null) {
      $xfer += $output->writeFieldBegin('count', TType::I32, 3);
      $xfer += $output->writeI32($this->count);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentReadService_getCommentOlder_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_ObjectComment',
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
    return 'CommentReadService_getCommentOlder_result';
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
            $this->success = new comment_ObjectComment();
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentOlder_result');
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

class comment_CommentReadService_getCommentById_args {
  static $_TSPEC;

  public $objectId = null;
  public $commentId = null;

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
        );
    }
    if (is_array($vals)) {
      if (isset($vals['objectId'])) {
        $this->objectId = $vals['objectId'];
      }
      if (isset($vals['commentId'])) {
        $this->commentId = $vals['commentId'];
      }
    }
  }

  public function getName() {
    return 'CommentReadService_getCommentById_args';
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentById_args');
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
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class comment_CommentReadService_getCommentById_result {
  static $_TSPEC;

  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => 'comment_Comment',
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
    return 'CommentReadService_getCommentById_result';
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
            $this->success = new comment_Comment();
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
    $xfer += $output->writeStructBegin('CommentReadService_getCommentById_result');
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

?>
