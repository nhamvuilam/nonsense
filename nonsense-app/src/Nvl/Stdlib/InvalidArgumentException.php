<?php
//
// InvalidArgumentException.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 7, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Stdlib;

/**
 * Exception thrown when arguments pass to a method is not acceptable, if user input is
 * invalid ValidateException will be thrown instead of this.
 *
 * @see ValidateException
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class InvalidArgumentException extends \Exception {
}