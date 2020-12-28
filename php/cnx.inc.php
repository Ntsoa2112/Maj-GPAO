
<?php
class Cnx extends PDO
{
	private $connexion;

	const DEFAULT_DNS = 'pgsql:host=localhost;dbname=suivibp';
	//const DEFAULT_DNS = 'pgsql:host=localhost port=5432;dbname=suivibp';
	const DEFAULT_SQL_USER = 'postgres';
	const DEFAULT_SQL_PASS = 'postgres';


	function Cnx()
	{
		$this->connexion = new PDO	(
									self::DEFAULT_DNS,
									self::DEFAULT_SQL_USER,
									self::DEFAULT_SQL_PASS
									);
		return;
	}
}
?>


