<?php
if (!defined('APPATH')) exit ('No direct script access alowed');
include 'config/database.php';
/**
 * class for databse
 */
class DB
{
	protected $_connection;
	protected $_config;

	/**
	 * 
	 * @param string $name neame of database you want to connect on
	 */
	public function __construct($name = 'default')
	{
		$conf = APPATH.'config/database.php';
		if(file_exists($conf)) {
			$cnf = include $conf;
			$this->_config = $cnf[$name];
		} else {
			throw new Exception ('Config file is missing.');
		}
	}

    /**
     * [fetchOne description]
     * @param  mysql $query 
     * @return   assoc array, one row form db table
     */
    public function fetchOne($query)
    {
        $sth = $this->_getConnection()->prepare($query);
        $sth->execute();

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * fetch all elements from table
     * @param  mysql $query 
     * @return associative array, all rows from db table
     */
    public function fetchAll($query)
    {
        $sth = $this->_getConnection()->prepare($query);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * executeing query
     * @param  mysql  $query  
     * @param  boolean $lastID 
     * @return booelan 
     */
    public function execute ($query, $lastID = FALSE)
    {
        $sth = $this->_getConnection()->prepare($query);
        $sth->execute();
        if($lastID == true) return $this->_getConnection()->lastInserdId();

        return true;
    }

    /**
     * connecting to database
     * @return  connection
     */
	public function _getConnection()
	{
        if($this->_connection === NULL){
            $user = $this->_config['username'];
            $pass = $this->_config['password'];
            $db   = $this->_config['database'];
            $host = $this->_config['hostname'];
            $dsn  = 'mysql:dbname=' . $db . ';host=' . $host . ';charset=utf8';
            try{
                $this->_connection = new \PDO($dsn, $user, $pass);
                $this->_connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT );
            }catch(\PDOException $e){
                throw new Exception("Could not connect to $db database.");
            }catch(Exception $e){
                throw new Exception("Could not connect to $db database.");
            }
        }

        return $this->_connection;
	}
}