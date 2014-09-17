<?php

/**
 * Google oauth2 authentication class
 */
class Core_OAuth_Google extends Core_OAuth_Abstract {
	private $authenticationEndPoint = 'https://accounts.google.com/o/oauth2/auth';
	private $requestTokenEndpoint = 'https://accounts.google.com/o/oauth2/token';
	private $userinfoEndpoint = 'https://www.googleapis.com/oauth2/v1/userinfo';

	protected function redirectAuthUrl() {
		$params = array(
			'response_type=code',
			'client_id=' . $this->consumerKey,
			'redirect_uri=' . urlencode($this->return_url),
			'state=' . $this->getCrsf(),
			'scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile',
			'access_type=online',
			'approval_prompt=auto'
		);
		header('Location: ' . $this->authenticationEndPoint . '?' . implode('&', $params));
	}
	protected function getAccessToken($code) {
		$data = array(
			'code' => $code,
			'redirect_uri' => $this->return_url,
			'client_id' => $this->consumerKey,
			'scope' => '',
			'client_secret' => $this->consumerSecret,
			'grant_type' => 'authorization_code',

		);

		// get token
		$response = $this->makeRequest($this->requestTokenEndpoint, http_build_query($data), 'post');

		if ($response[0] == 200) {
			return json_decode($response[1]);
		}
		return null;
	}
	protected function populateUser($tokeninfo) {
		// get userinfo with granted token
		if ($tokeninfo->access_token) {
			$response = $this->makeRequest($this->userinfoEndpoint . '?access_token=' . $tokeninfo->access_token, array(), 'get');
			if ($response[0] == 200) {
				$userinfo = json_decode($response[1]);
				$this->user['name'] = $userinfo->name;
				$this->user['first_name'] = $userinfo->given_name;
				$this->user['last_name'] = $userinfo->family_name;
				$mail_parts = explode('@', $userinfo->email);
				$this->user['username'] = $mail_parts[0];
				$this->user['gender'] = $userinfo->gender == 'male' ? '0' : '1';
				$this->user['email'] = $userinfo->email;
                $this->user['id'] = $userinfo->id;
			}
		}
	}
}
?>
