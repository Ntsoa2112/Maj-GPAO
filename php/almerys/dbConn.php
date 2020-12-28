<?php

class DBConn
{
	  /**
	   * Instance de la classe PDO
	   *
	   * @var PDO
	   * @access private
	   */ 
	  private $PDOInstance = null;
	 
	   /**
	   * Instance de la classe DBConn
	   *
	   * @var DBConn
	   * @access private
	   * @static
	   */ 
	  private static $instance = null;
	 
	  /**
	   * Constante: nom d'utilisateur de la bdd
	   *
	   * @var string
	   */
	  const DEFAULT_PG_USER = 'gpao_batch';
	 
	  /**
	   * Constante: hôte de la bdd
	   *
	   * @var string
	   */
	  const DEFAULT_PG_HOST = '10.128.1.2';
	 
	 /**
	   * Constante: port de la bdd
	   *
	   * @var string
	   */
	  const DEFAULT_PG_PORT = '5432';
	 
	  /**
	   * Constante: mot de passe de la bdd
	   *
	   * @var string
	   */
	  const DEFAULT_PG_PASS = '$gpao_batch$$';
	 
	  /**
	   * Constante: nom de la bdd
	   *
	   * @var string
	   */
	  const DEFAULT_PG_DTB = 'almerys';
	 
	  /**
	   * Constructeur
	   *
	   * @param void
	   * @return void
	   * @see PDO::__construct()
	   * @access private
	   */
	  private function __construct()
	  {
		$this->PDOInstance = new PDO('pgsql:dbname='.self::DEFAULT_PG_DTB, self::DEFAULT_PG_USER, self::DEFAULT_PG_PASS);    
	  }
	 
	 /*.';host='.self::DEFAULT_PG_HOST.';port='.self::DEFAULT_PG_PORT.';user='.  .';password='.*/
	 
	   /**
		* Crée et retourne l'objet DBConn
		*
		* @access public
		* @static
		* @param void
		* @return DBConn $instance
		*/
	  public static function getInstance()
	  {  
		if(is_null(self::$instance))
		{
		  self::$instance = new DBConn();
		}
		return self::$instance;
	  }
	 
	  /**
	   * Exécute une requête SQL avec PDO
	   *
	   * @param string $query La requête SQL
	   * @return PDOStatement Retourne l'objet PDOStatement
	   */
	  public function query($query)
	  {
		return $this->PDOInstance->query($query);
	  }
}

?>