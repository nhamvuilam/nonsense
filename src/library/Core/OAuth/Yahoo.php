<?php

/**
 * Class that handle the oauth process with Yahoo provider
 * Note that this class use OAuth version 1 and it use the OAuth library to communicate with provider
 */
class Core_OAuth_Yahoo extends Core_OAuth_Abstract {

    protected $version = 1;
    private $requestTokenEndpoint = 'https://api.login.yahoo.com/oauth/v2/get_request_token';
    private $authorizationEndpoint = 'https://api.login.yahoo.com/oauth/v2/request_auth';
    private $accessTokenEndpoint = 'https://api.login.yahoo.com/oauth/v2/get_token';
    private $userInfoEndpoint = 'http://social.yahooapis.com/v1/user/{guid}/profile';

    public function __construct($url, $type, $prxy = null, $prxy_port = null) {
        parent::__construct($url, $type, $prxy, $prxy_port);
        include( dirname(__FILE__) . '/../../OAuth/OAuth.php');
    }

    protected function redirectAuthUrl() {
        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);

        $parameters = array();
        $parameters['oauth_callback'] = $this->return_url;

        $request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'GET', $this->requestTokenEndpoint, $parameters);
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);

        $response = $this->makeRequest($request->to_url(), array(), 'get', array(), true);
        if ($response[0] == '200') {
            $token = OAuthUtil::parse_parameters($response[1]);
            // Saving them into the session for using in get access token step
            $_SESSION['yahoo_oauth_token'] = $token['oauth_token'];
            $_SESSION['yahoo_oauth_token_secret'] = $token['oauth_token_secret'];

            header('Location: ' . $this->authorizationEndpoint . '?oauth_token=' . $token['oauth_token'] . '&state=' . $this->getCrsf());
        }
    }

    protected function populateUser($returnToken) {

        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $token = new OAuthToken($returnToken['oauth_token'], $returnToken['oauth_token_secret']);

        $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', str_replace('{guid}', $returnToken['xoauth_yahoo_guid'], $this->userInfoEndpoint), array('format' => 'json'));
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);

        $response = $this->makeRequest($request->to_url());
        if ($response[0] == 200) {
            $user = json_decode($response[1]);
            $this->user['name'] = $user->profile->familyName . ' ' . $user->profile->givenName;
            $this->user['first_name'] = $user->profile->givenName;
            $this->user['last_name'] = $user->profile->familyName;
            foreach ($user->profile->emails as $email) {
                if (isset($email->handle)) {
                    $this->user['email'] = $email->handle;
                    break;
                }
            }
            $mailParts = explode('@', $this->user['email']);
            $this->user['username'] = $mailParts[0];
            $this->user['gender'] = $user->profile->gender == 'M' ? '0' : '1';
            $this->user['yearOfBirth'] = $user->profile->birthYear;
            $this->user['id'] = $user->profile->guid;
        }
    }

    protected function getAccessToken($code) {
        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $token = new OAuthToken($_SESSION['yahoo_oauth_token'], $_SESSION['yahoo_oauth_token_secret']);
        $parameters = array();
        $parameters['oauth_verifier'] = $code;
        $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $this->accessTokenEndpoint, array('oauth_verifier' => $code));
        $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);
        $response = $this->makeRequest($request->to_url());
        return OAuthUtil::parse_parameters($response[1]);
    }

    protected function getCrsfKey() {
        return 'oauth_nonce';
    }

    protected function getAuthorizationKey() {
        return 'oauth_verifier';
    }

}

?>
