<?php
class Core_Solr_DocumentHandler {
    /**
     * Solr object
     * @var Core_Solr
     */
    protected $solr;

    /**
     * Logger object
     * @var Core_Logger
     */
    protected $log;

    /**
     * Constructors.
     */
    public function __construct() {
        $this->log = Core_Logger::getLogger($this);
    }

    /**
     * Set Solr Instance
     * @param Core_Solr $solr The solr instance
     */
    public function setSolr(Core_Solr $solr) {
        $this->solr = $solr;
    }
    
    
    public function syncTestSolr(){
        // delete all document in solr before synchronizing
        $this->deleteAll();
       // get modified products
        $productIds = $this->getProductIds();
        $this->log->info('Adding ' . count($productIds). ' products...');

        // add products to solr
        try {
            $syncCount = $this->syncProducts($productIds);
            echo "{$syncCount} products has been added!<br>";
            //$this->log->info("{$syncCount} products has been added!");
            return $syncCount;
        } catch (Exception $e) {
            $this->log->error($e);
            return false;
        }
    }
    
    /**
     * Delete all document in Solr
     * @return boolean
     */
    public function deleteAll() {
        //$this->log->info("Deleting everything...");
        echo "Deleting everything...<br>";
        try{
            $this->solr->getSolrService()->deleteByQuery("*:*");
        }  catch (Exception $e){
            echo 'debug....';
            echo $e->getMessage();
            exit;
        }
        return true;
    }
    
    /**
     * Return list of product id
     * @param boolean $childOrInactiveProduct
     * @return array An array of product_id
     */
    protected function getProductIds($inactiveProduct = false) {
        $select = $this->getProductIdsQuery($inactiveProduct);
        $stmt = $select->query();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    
    /**
     * Return Zend_Db_Select object to select products table
     * @param boolean $inactiveProduct False to get active and parent products, otherwise True. OPTIONAL
     * @return Zend_Db_Select
     */
    protected function getProductIdsQuery($inactiveProduct = false) {
        $select = Core_Global::getDbSlave()->select();
        $select->from(array('p' => 'products'),
                      array('product_id'));
        return $select;
    }
    
    /**
     * Adding products to solr
     * @param array $productIds An array of product id to add
     * @throws Exception
     * @return number The number of added products
     */
    protected function syncProducts(array $productIds) {
        $count = 0;

        // check solr status
        if (!$this->solr->isAlive()) {
            // throw exception when solr is down or unreachable
            $e = new Exception('Solr is down!');
            $this->log->error($e);
            throw $e;
        }

        echo "Adding " . count($productIds) . ' products<br>';

        // add all product to solr
        foreach ($productIds as $id) {
            if ($this->syncProduct($id, false) === true) {
                $count++;
            }
        }

        return $count;
    }
    
    /**
     * Sync a specific product
     * @param number $productId The product id
     * @param boolean $pingFirst Verify Solr is alive or not
     * @throws Exception
     * @return boolean
     */
    public function syncProduct($productId, $pingFirst = true) {
        // only sync if Solr is avalable
        if (empty($this->solr)) {
            throw new Exception('Solr Instance was not set');
        }

        // verify solr instance and add document
        if ($pingFirst == true) {
            if (!$this->solr->isAlive()) {
                // throw exception when solr is down or unreachable
                $e = new Exception('Solr is down!');
                $this->log->error($e);
                throw $e;
            }
        }

        //$this->log->info("Building product data for {$productId}...");
        echo "Building product data for {$productId}...<br>";
        $product = $this->getDocumentFields($productId);
        if (!empty($product) && !empty($product->id)) {
            try {
                // prepares all required data fields for solr documents
                //$product = $this->prepareSolrDocument($product);
                if ($product === null) {
                    return false;
                }

                // adds product to solr
                //$this->log->info("Adding product {$productId}...");
                echo "Adding product {$productId}...<br>";
                $response = $this->solr->getSolrService()->addDocument($product, false, true, true, 10000 );
                if ($response->getHttpStatus() == 200) {
                    //$this->log->info("{$productId} added");
                    echo "{$productId} added<Br>";
                }
            } catch (Exception $e) {
                $this->log->error($e);
                return false;
            }
        } else {
            $this->log->info("Product {$productId} not found !!!}");
            return false;
        }
        return true;
    }
    
    /**
     * Return an array of product fields to add to Solr
     * @param number $id The id of product to find
     * @return array|NULL An array of found product fields or null
     */
    protected function getDocumentFields($id) {        
        $db = Core_Global::getDbSlave();
        $db->setFetchMode(PDO::FETCH_OBJ);

        $stmt = $db->prepare("
            SELECT product_id as id, product_name FROM products WHERE product_id=:id
		");
        
        $stmt->bindValue('id', (int) $id, PDO::PARAM_INT);        
        try{
        $stmt->execute();        
        }  catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $product = $stmt->fetchObject("Apache_Solr_Document");        
        $stmt->closeCursor();

        $db->setFetchMode(PDO::FETCH_ASSOC);

        if (!empty($product)) {
            return $product;
        }
        return null;
    }

}
