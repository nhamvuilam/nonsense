<?php
//
// PaginatedResult.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 2, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Stdlib;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class PaginatedResult {

    private $total;
    private $limit;
    private $current;
    private $data;

    public function __construct($limit, $current, $total, $data) {
        $this->limit = $limit;
        $this->current = $current;
        $this->total = $total;
        $this->data = $data;
    }

    public function data() {
        return $this->data;
    }

    public function total() {
        return $this->total;
    }

    public function current() {
        return $this->current;
    }

    public function next() {
        if (($next = $this->current + $this->limit) > $this->total) {
            return null;
        }

        return $next;
    }

    public function previous() {
        if (($prev = $this->current - $this->limit) < 0) {
            return null;
        }
        return $prev;
    }
}
