<?php
//
// OAuthFactory.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 5, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\OAuth;

/**
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class OAuthFactory {

	private $config;

	/**
	 * Constructor
	 */
	public function __construct($config) {
        $this->config = $config;
	}

	/**
	 * OAuthFactory method which returns a handler object for specific social network
	 *
	 * @param $type The social network type
	 * @return AbstractOAuth OAuth object for specific type or null if type is not supported
	 */
	public function getOAuth($type) {
	    $type = strtolower($type);
		$class = '\\Nvl\\OAuth\\'.ucfirst($type).'OAuth';
		if (isset($class) && class_exists($class)) {
			$oauth = new $class($this->config['callback_url'], $type);
            $oauth->consumerKey = $this->config[$type.'.key'];
            $oauth->consumerSecret = $this->config[$type.'.secret'];
            return $oauth;
		}
		return null;
	}
}
