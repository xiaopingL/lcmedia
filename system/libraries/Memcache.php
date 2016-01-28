<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * Memcache Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Memcache
 * @author      zhang yan sheng
 */

class CI_Memcache {

    protected $host = '192.168.1.246';
    protected $port = '11211';
    protected $timeout = '3600';
    protected $memcache = '';

    public function __construct($params = array()) {
        if(!empty ($params)){
            $this->host = $params['host'];
            $this->port = $params['port'];
            $this->timeout = $params['timeout'];
        }else{
            $this->host = $this->host;
            $this->port = $this->port;
            $this->timeout = $this->timeout;
        }

        $this->memcache = new Memcache;
        $this->memcache->connect($this->host, $this->port);
    }


    /**
     * set
     *
     * @param 	string		unique identifier
     * @param 	mixed		data being cached
     * @param 	int			time to live
     * @return 	boolean 	true on success, false on failure
     */
    public function set($key,$value,$time=''){
        if(empty($time)) $time = $this->timeout;
        $this->memcache->set($key,$value,MEMCACHE_COMPRESSED,$time);
    }


    /**
     * Fetch from cache
     *
     * @param 	mixed		unique key id
     * @return 	mixed		data on success/false on failure
     */
    public function get($key){
        return $this->memcache->get($key);
    }


     /**
     * Delete from Cache
     *
     * @param 	mixed		key to be deleted.
     * @return 	boolean 	true on success, false on failure
     */
    public function delete($key){
        return $this->memcache->delete($key);
    }


}
?>
