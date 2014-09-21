<?php
//
// PostRepository.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Persistence\Mongo;

use Nvl\Cms\Domain\Model\PostRepository;

/**
 * Mongo Db Post Repository implementation
 */
class MongoPostRepository extends MongoRepository implements PostRepository {

    public function __construct($options) {
        parent::__construct($options);
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Domain\Model\PostRepository::find()
     */
    public function find($id) {
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Domain\Model\PostRepository::add()
     */
    public function add($post) {
        $this->collection()->insert($post->toArray());
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Domain\Model\PostRepository::save()
     */
    public function save($post) {

    }

    public function latestOfTag($tag, $limit = 10) {
    	$cursor = $this->collection()->find(array(
    		'tags' => $tag,
    	));
    	$cursor->sort(array('created_date' => -1))->limit($limit);

    	return $cursor;
    }

    public function latestOfCategory($category, $limit = 10) {}

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Adapter\Persistence\Mongo\MongoRepository::collectionName()
     */
    public function collectionName() {
        return 'posts';
    }
}
