<?php

namespace Nvl\Cms\Adapter\Persistence\Mongo;

/**
 *
 * @author qunguyen
 *
 */
abstract class MongoRepository {

    private $mongoDb;

    public function __construct($options) {
        $this->mongoDb = $options['db'];
    }

    protected abstract function collectionName();

    /**
     * @return \MongoCollection
     */
    protected function collection() {
        return $this->mongoDb->{$this->collectionName()};
    }

}