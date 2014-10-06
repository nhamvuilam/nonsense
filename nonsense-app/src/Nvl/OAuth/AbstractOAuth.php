<?php
namespace Nvl\OAuth;

/**
 * AbstractOAuth class that defines workflow for oauth process.
 * Class that extends this class must implement some abstract functions to
 * ensure the whole oauth process will works well
 */
abstract class AbstractOAuth {

    /**
     * Oauth consumer key provided by oauth provider
     * @var string
     */
    public $consumerKey = null;

    /**
     * Oauth consumer secret provided by oauth provider
     * @var string
     */
    public $consumerSecret = null;

    /**
     * The url that oauth provider will redirect to after authenticate user
     * @var string
     */
	protected $return_url = '';

    /**
     * Proxy to use to communicate with oauth provide
     * e.g. http://127.0.0.1
     * @var string
     */
	protected $proxy = null;
    /**
     * Proxy port
     * @var int
     */
	protected $proxyPort = null;

    /**
     * User info
     * @var array
     */
	protected $user = null;

    /**
     * OAuth version being used. Default is version 2
     * @var int
     */
    protected $version = 2;

    /**
     * Constructor
     */
	public function __construct($url, $provider, $prxy = null, $prxy_port = null) {
		$this->return_url = $url.'/'.$provider;
		$this->proxy = $prxy;
		$this->proxyPort = $prxy_port;
	}

	final public static function getInstance($url, $prxy = null, $prxy_port = null) {
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass($url, $prxy, $prxy_port);
        }

        return $instances[$calledClass];
    }

	/**
	 * Return authenticated user infos
	 */
	public function getUserInfo() {
		return $this->user;
	}

	/**
	 * Handle authentication process
	 */
	public function process() {
		if (isset($_REQUEST[$this->getAuthorizationKey()])) {

            // check if crsf of request is similar to the one generated before to verify the request
            if (!isset($_SESSION[$this->getCrsfKey()])
                || ($this->version == 2
                    && $_REQUEST[$this->getCrsfKey()] != $_SESSION[$this->getCrsfKey()])) {

                throw new \Exception('Ops! Look like there are something wrong. What are you trying to do?');
            }

            // we have just received authorization code, exchange its for access token
			$token = $this->getAccessToken($_REQUEST[$this->getAuthorizationKey()]);

			// use access token to get userinfo
			if ($token) {
				$this->populateUser($token);
			} else {
				throw new \Exception('Cannot get token');
			}
		} else {
			// this is the first request, so redirect user to Facebook to asking for authorization
			$this->redirectAuthUrl();
			exit;
		}
	}


	/**
	 * Retrieve access token
	 */
	abstract protected function getAccessToken($code);

	/**
	 * Populate user info
	 */
	abstract protected function populateUser($token);

	/**
	 * Redirect user to authorization url for login and ask for permission
	 */
	abstract protected function redirectAuthUrl();


	/**
	 * Return the parameter name for authorization code returned
	 */
	protected function getAuthorizationKey() { return 'code'; }

    /**
	 * Return CRSF key which identify a value in $_SESSION (random)
	 */
	protected function getCrsfKey() { return 'state'; }

	/**
	 * Return random CRSF value and store the generated value in session variable
	 */
	protected function getCrsf() {
		if ($_SESSION[$this->getCrsfKey()]) {
			return $_SESSION[$this->getCrsfKey()];
		}
		$_SESSION[$this->getCrsfKey()] = md5(uniqid(rand(), true));
		return $_SESSION[$this->getCrsfKey()];
	}

	/**
	 * Send request to an URL and return the result
	 *
     * @param $endpoint The URL to make request
     * @param $params An array of request parameters
     * @param $method The http method to use. e.g. 'get' or 'post'
     * @param $header An array of header parameters
     * @param $debug Print debug info or not (true or false)
	 */
	protected function makeRequest($endpoint, $params = array(), $method = 'get', $header = null, $debug = false) {
		$ch = curl_init();
		// endpoint
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

        if ($header != null) {
            curl_setopt($ch, CURLOPT_HEADER, $header);
        }

        if ($debug === true) {
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

		// set method
		if ('get' == strtolower($method)) {
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
		} else if ('post' == strtolower($method)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}

		// set proxy if any
		if ($this->proxy != null && $this->proxyPort != null) {
			curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxyPort);
			curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}

		// execute request
		$response = curl_exec($ch);

        if ($debug === true) {
            print "<p><pre>";
            print_r(curl_getinfo($ch)); // get error info
            echo "\n\ncURL error number:" .curl_errno($ch); // print error info
            echo "\n\ncURL error:" . curl_error($ch);
            print "</pre><p>";
        }
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return array($http_status, $response);
	}
}
