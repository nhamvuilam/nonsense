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

use Doctrine\ODM\MongoDB\DocumentManager;
use Nvl\Cms\Domain\Model\Post\PostRepository;

/**
 * Mongo Db Post Repository implementation
 */
class MongoPostRepository implements PostRepository {

    private $dm;

    public function __construct(DocumentManager $dm) {
        //parent::__construct($options);
        $this->dm = $dm;
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
        var_dump($post);
        $this->dm()->persist($post);
        $this->dm()->flush();
        // $this->collection()->insert($post->toArray());
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Domain\Model\PostRepository::save()
     */
    public function save($post) {

    }

    public function latestOfTag($tag, $limit = 10) {
        return $this->dm()->createQueryBuilder('\Nvl\Cms\Domain\Model\Post\Post')
                         ->select()
                         ->sort(array('createdDate' => -1))
                         ->limit($limit)->getQuery()->execute();
        /*
    	$cursor = $this->collection()->find(array(
    		'tags' => $tag,
    	));
    	$cursor->sort(array('created_date' => -1))->limit($limit);

    	return $cursor;
    	*/

    }

    public function latestOfCategory($category, $limit = 10) {}

    /**
     * @return DocumentManager
     */
    public function dm() {
        return $this->dm;
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Adapter\Persistence\Mongo\MongoRepository::collectionName()
     */
    public function collectionName() {
        return 'posts';
    }
}
