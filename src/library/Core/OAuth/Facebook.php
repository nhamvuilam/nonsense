<?php

/**
 * Facebook oauth2 authentication class
 */
class Core_OAuth_Facebook extends Core_OAuth_Abstract {

    /**
     * Ask facebook for authenticate user and permission to use user information
     */
    protected function redirectAuthUrl() {
        header('Location: https://www.facebook.com/dialog/oauth/?client_id=' . $this->consumerKey
                . '&redirect_uri=' . urlencode($this->return_url)
                . '&state=' . $this->getCrsf()
                . '&scope=publish_actions,email&display=popup');
    }

    /**
     * Retrieve access token
     */
    protected function getAccessToken($code) {
        // get access token to get user info
        $token_url = "https://graph.facebook.com/oauth/access_token?"
                . "client_id=" . $this->consumerKey . "&redirect_uri=" . urlencode($this->return_url)
                . "&client_secret=" . $this->consumerSecret . "&code=" . $code;
        $response = $this->makeRequest($token_url, array(), 'get');
        if ($response[0] == 200) {
            $params = null;
            parse_str($response[1], $params);
            return $params;
        }
        return null;
    }

    /**
     * Populate user info
     */
    protected function populateUser($token) {
        // get user info
        $graph_url = "https://graph.facebook.com/me?access_token=" . $token['access_token'];
        $response = $this->makeRequest($graph_url, array(), 'get');

        if ($response[0] == 200) {
            $user = json_decode($response[1]);
            $this->user['name'] = $user->name;
            $this->user['first_name'] = $user->first_name;
            $this->user['last_name'] = $user->last_name;
            $this->user['username'] = $user->username;
            $this->user['gender'] = $user->gender == 'male' ? '0' : '1';
            $this->user['email'] = $user->email;
            $this->user['id'] = $user->id;
        }
    }

}

?>
