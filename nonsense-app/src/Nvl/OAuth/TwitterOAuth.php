<?php
namespace Nvl\OAuth;

/**
 * Class that handle the oauth process with TwitterOAuth provider
 * Note that this class use OAuth version 1 and it use the OAuth library to communicate with provider
 */
class TwitterOAuth extends AbstractOAuth {

    protected $version = 1;
	private $consumerKey = 'Irvt8aMFhtlycfj2IxbA';
	private $consumerSecret = 'xlnuq4LhToZPkJ4v4m02W2mjrZGjbvluH0nu0RHmA';
    private $requestTokenEndpoint = 'https://api.twitter.com/oauth/request_token';
    private $authorizationEndpoint = 'https://api.twitter.com/oauth/authorize';
    private $accessTokenEndpoint = 'https://api.twitter.com/oauth/access_token';
    private $userInfoEndpoint = 'https://api.twitter.com/1/account/verify_credentials.json';

    protected function getAuthorizationKey() { return 'oauth_verifier'; }

    public function __construct($url, $prxy = null, $prxy_port = null) {
        parent::__construct($url, $prxy, $prxy_port);
        require_once( dirname(__FILE__) . '/../../../../library/OAuth/OAuth.php');
    }

    /**
	 * Populate user info
	 */
	protected function populateUser($token) {

        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $token = new OAuthToken($token['oauth_token'], $token['oauth_token_secret']);

        $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $this->userInfoEndpoint);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);

        $response = $this->makeRequest($request->to_url());
        if ($response[0] == 200) {
        	$user = json_decode($response[1]);
            print_r($user);
			$this->user['name'] = $user->name;
			$this->user['first_name'] = '';
			$this->user['last_name'] = '';
			$this->user['username'] = $user->screen_name;
			$this->user['gender'] = '';
			$this->user['email'] = '';
        }

	}

    protected function getAccessToken($code) {

        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $token = new OAuthToken($_SESSION['twitter_oauth_token'], $_SESSION['twitter_oauth_token_secret']);
        $parameters = array();
        $parameters['oauth_verifier'] = $code;
        $request = OAuthRequest::from_consumer_and_token($consumer,
                                                         $token,
                                                         'GET',
                                                         $this->accessTokenEndpoint, $parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);
        $response = $this->makeRequest($request->to_url());

        return OAuthUtil::parse_parameters($response[1]);
    }

	protected function redirectAuthUrl() {
        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);

        // initial request for the request token first
        $request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'GET', $this->requestTokenEndpoint, array('oauth_callback' =>  $this->return_url . '?s=twitter'));
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
        $response = $this->makeRequest($request->to_url(), array(), 'get', array(), true);

        // redirect user to provider's authorization page to ask for resource access permission
	    if ($response[0] == '200') {
			$token = OAuthUtil::parse_parameters($response[1]);
			// Saving them into the session for getting access token later
			$_SESSION['twitter_oauth_token'] = $token['oauth_token'];
			$_SESSION['twitter_oauth_token_secret'] = $token['oauth_token_secret'];

	        header('Location: ' . $this->authorizationEndpoint . '?oauth_token=' . $token['oauth_token'] . '&state=' . $this->getCrsf());
        }

	}
}
