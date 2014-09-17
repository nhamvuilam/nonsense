<?php

class Core_Global {

    /**
     * Zend_Config_Ini
     * @var Zend_Config_Ini $config
     */
    private static $config = null;

    /**
     * List mysqli storage
     */
    private static $arrStorage = array();

    /**
     * Get application application config     
     * @return <object>
     */
    public static function getApplicationIni() {

        //Get Ini Configuration
        if (is_null(self::$config)) {
            if (Zend_Registry::isRegistered(APP_CONFIG)) {
                self::$config = Zend_Registry::get(APP_CONFIG);
            } else {
                $application = new Zend_Config_Ini(APPLICATION_PATH . '/configs/'.MODULE.'/application-' . APPLICATION_ENV . '.ini', APPLICATION_ENV);
                self::$config = new Zend_Config($application->toArray());
                Zend_Registry::set(APP_CONFIG, self::$config);
            }
        }

        //Return data
        return self::$config;
    }

    /**
     * Get caching sharding instance     
     * @return <Core_Cache>
     */
    public static function getCaching() {
        static $caching = null;
        if(!isset($caching)) {
            Core_Log::getInstance()->log(array(__CLASS__,__FUNCTION__,'init cache'));
            $frontendOptions = array('lifetime' => null, 'automatic_serialization' => true);
            $backendOptions = array('cache_dir' => realpath(ROOT_DIR . '/cache/')); // getting a Zend_Cache_Core object
            $caching = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        }
        //Return caching
        return $caching;
    }

    /**
     * Get admin storage instance
     * @return <Zend_Db>
     */
    public static function getDbMaster() {
        static $storageMaster = null;

        //Get Ini config
        if (is_null(self::$config)) {
            self::$config = self::getApplicationIni();
        }

        //Get storage instance
        if (is_null($storageMaster)) {
            //Set UTF-8 Collate and Connection
            $options_storage = self::$config->database->master->toArray();

            //Set params
            if (empty($options_storage['params']['driver_options'])) {
                $options_storage['params']['driver_options'] = array(
                    1002 => 'SET NAMES \'utf8\'',
                    12 => 0
                );
            }

            //Create object to Connect DB
            $storageMaster = Zend_Db::factory($options_storage['adapter'], $options_storage['params']);

            //Changing the Fetch Mode
            $storageMaster->setFetchMode(Zend_Db::FETCH_ASSOC);

            // Create Adapter default is Db_Table
            Zend_Db_Table::setDefaultAdapter($storageMaster);

            //Unclean
            unset($options_storage);

            //Push to queue
            self::$arrStorage[] = $storageMaster;
        }

        //Return storage
        return $storageMaster;
    }

    /**
     * Close all mysqli connection
     * @return <bool>
     */
    public static function closeAllDb() {
        //Loop to close connection
        if (sizeof(self::$arrStorage) > 0) {
            //Loop to close connection
            foreach (self::$arrStorage as $storage) {
                //Try close
                if (is_object($storage) && ($storage->isConnected())) {
                    //Close connection
                    $storage->closeConnection();

                    //Set storage is null
                    unset($storage);
                }
            }

            //Set all list connection
            self::$arrStorage = array();
        }
    }

}

?>