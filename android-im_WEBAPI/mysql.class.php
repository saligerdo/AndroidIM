<?php
/************************************************
*
*   File Name: 	 mysql.php
*   Begin: 		 Sunday, Dec, 23, 2005
*   Author: 	 ahmet oðuz mermerkaya
*   Email: 		 ahmetmermerkaya@hotmail.com
*   Description: Class to connect mysql database
*	Edit : 		 Sunday, Nov, 18, 2007
*   Version: 	 1.1
*
***********************************************/
class MySQL
{
	private $dbLink;
	private $dbHost;
	private $dbUsername;
    private $dbPassword;
	private $dbName;
	public  $queryCount;

	function MySQL($dbHost,$dbUsername,$dbPassword,$dbName)
	{
		$this->dbHost = $dbHost;
		$this->dbUsername = $dbUsername;
		$this->dbPassword = $dbPassword;
		$this->dbName = $dbName;
		$this->queryCount = 0;
	}
	function __destruct()
	{
		$this->close();
	}
	//connect to database
	private function connect() {
		$this->dbLink = mysqli_connect($this->dbHost, $this->dbUsername, $this->dbPassword);
		if (!$this->dbLink)	{
			$this->ShowError();
			return false;
		}
		else if (!mysqli_select_db($this->dbLink, $this->dbName))	{
			$this->ShowError();
			return false;
		}
		else {
			mysqli_query($this->dbLink, $this->dbLink, "set names utf8");
			return true;
		}
		unset ($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
	}
	/*****************************
	 * Method to close connection *
	 *****************************/
	function close()
	{
		@mysqli_close($this->dbLink);
	}
	/*******************************************
	 * Checks for MySQL Errors
	 * If error exists show it and return false
	 * else return true
	 *******************************************/
	function ShowError()
	{
		$error = mysqli_error($this->dbLink);
		//echo $error;
	}
	/****************************
	 * Method to run SQL queries
	 ****************************/
	function  query($sql)
	{
		if (!$this->dbLink)
			$this->connect();

		if (! $result = mysqli_query($this->dbLink, $sql)) {
			$this->ShowError();
			return false;
		}
		$this->queryCount++;
		return $result;
	}
	/************************
	* Method to fetch values*
	*************************/
	function fetchObject($result)
	{
		if (!$Object=mysqli_fetch_object($result))
		{
			$this->ShowError();
			return false;
		}
		else
		{
			return $Object;
		}
	}
	/*************************
	* Method to number of rows
	**************************/
	function numRows($result)
	{
		if (false === ($num = mysqli_num_rows($result))) {
			$this->ShowError();
			return -1;
		}
		return $num;
	}
	/*******************************
	 * Method to safely escape strings
	 *********************************/
	function escapeString($string)
	{
		if (get_magic_quotes_gpc())
		{
			return $string;
		}
		else
		{
			$string = mysqli_escape_string($string);
			return $string;
		}
	}

	function free($result)
	{
		if (mysqli_free_result($result)) {
			$this->ShowError();
			return false;
		}
		return true;
	}

	function lastInsertId()
	{
		return mysqli_insert_id($this->dbLink);
	}

	function getUniqueField($sql)
	{
		$row = mysqli_fetch_row($this->query($sql));

		return $row[0];
	}

	function createDB() {
        $createUsers = "CREATE TABLE IF NOT EXISTS users (
        Id int(10) unsigned NOT NULL AUTO_INCREMENT,
        username varchar(45) NOT NULL DEFAULT '',
        password varchar(32) NOT NULL DEFAULT '',
        email varchar(45) NOT NULL DEFAULT '',
        date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        status tinyint(3) unsigned NOT NULL DEFAULT '0',
        authenticationTime datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        userKey varchar(32) NOT NULL DEFAULT '',
        IP varchar(45) NOT NULL DEFAULT '',
        port int(10) unsigned NOT NULL DEFAULT '0',
        PRIMARY KEY (Id),
        UNIQUE KEY Index_2 (username),
        KEY Index_3 (authenticationTime)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=7";

        $createFriends = "CREATE TABLE IF NOT EXISTS friends (
        Id int(10) unsigned NOT NULL AUTO_INCREMENT,
        providerId int(10) unsigned NOT NULL DEFAULT '0',
        requestId int(10) unsigned NOT NULL DEFAULT '0',
        status binary(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (Id),
        UNIQUE KEY Index_3 (providerId,requestId),
        KEY Index_2 (providerId,requestId,status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='providerId is the Id of the users who wish to be friend with' AUTO_INCREMENT=7";

        $createMessages = "CREATE TABLE IF NOT EXISTS `messages` (
		`id` int(255) NOT NULL AUTO_INCREMENT,
		`fromuid` int(255) NOT NULL,
		`touid` int(255) NOT NULL,
		`sentdt` datetime NOT NULL,
		`read` tinyint(1) NOT NULL DEFAULT '0',
		`readdt` datetime DEFAULT NULL,
		`messagetext` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
		PRIMARY KEY (`id`),
		KEY `id` (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ";

        $this->query($createUsers);
        $this->query($createFriends);
        $this->query($createMessages);

    }

	function testconnection() {
		$this->dbLink = mysqli_connect($this->dbHost, $this->dbUsername, $this->dbPassword);
		if (!$this->dbLink)	{
			$this->ShowError();
			return false;
		}
		else if (!mysqli_select_db($this->dbLink, $this->dbName))	{
			$this->ShowError();
			return false;
		}
		else {
			mysqli_query($this->dbLink, "set names utf8");
			return true;
		}
		unset ($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
	}
}