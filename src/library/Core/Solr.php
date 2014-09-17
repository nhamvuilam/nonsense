<?php
require_once(dirname(__FILE__) . '/../Apache/Solr/Service.php');
/**
 * Solr search component which provide API to interacting with the Solr Server.
 * This class utilizes the SolrPhpClient package for Solr manipulation
 *
 * @version 1.0
 * @author QuyetNM
 *
 * @link Core_Global
 * @link Apache_Solr_Service
 */
class Core_Solr  {

    /**
     * Solr service
     * @var Apache_Solr_Service
     */
    protected $solrService;

    /**
     * Solr configuration
     * @var stdClass
     */
    protected $solrServer;

    /**
     * Search handler
     * @var Core_Search
     */
    protected $searchHandler = array();

    /**
     * Document handler
     * @var Core_Solr_DocumentHandler
     */
    protected $documentHander;

    /**
     * Constructors. All parameters are optional.
     *
     * If parameters is not specified, the default one in <em>application-config.ini</em> will be use.
     * Please config Solr server endpoint using these config keys:
     * api.server, api.port, api.path
     *
     * @param string $server The IP address of server. OPTIONAL
     * @param string $port   The server port. OPTIONAL
     * @param string $path   The path to installed Solr instance. OPTIONAL
     */
    public function __construct($server = null, $port = null, $path = null) {
        // create new solr service handler to point to our solr server
        if (! $server || ! $port || ! $path) {
            $this->solrServer = Core_Global::getApplicationIni()->api->solr;
        } else {
            $this->solrServer = new stdClass();
            $this->solrServer->server = $server;
            $this->solrServer->port = $port;
            $this->solrServer->path = $path;
        }
        $this->solrService = new Apache_Solr_Service($this->solrServer->server,
                $this->solrServer->port, $this->solrServer->path);
    }

    /**
     * Return search handler
     * @return Core_Search
     */
    public function getSearchHandler($class = '') {
        if (empty($class)) {
            $class = 'SearchHandler';
        }

        $class = "Core_Solr_{$class}";
        if (empty($this->searchHandler) || empty($this->searchHandler[$class])) {
            $this->searchHandler[$class] = new $class();
            $this->searchHandler[$class]->setSolr($this);
        }
        return $this->searchHandler[$class];
    }

    /**
     * Return document handler
     * @return Core_Solr_DocumentHandler
     */
    public function getDocumentHandler() {
        if (empty($this->documentHandler)) {
            $this->documentHandler = new Core_Solr_DocumentHandler();
            $this->documentHandler->setSolr($this);
        }
        return $this->documentHandler;
    }

    /**
     * Return Apache_Solr_Service
     * @return Apache_Solr_Service
     */
    public function getSolrService() {
        return $this->solrService;
    }

    /**
     * Check server is alive
     * @return boolean
     */
    public function isAlive() {
        return $this->solrService->ping() != false;
    }

}