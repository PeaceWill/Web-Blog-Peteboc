<?php
if (session_id() == '') {
	session_start();
}

require_once 'connection.php';
require_once '../../config/config.php';
class About extends Connection
{
	private $about_table = ABOUT_TABLE;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *   SELECT 
	*/

	public function getAboutContent()
	{
		$stmt = $this->link->prepare("SELECT * FROM $this->about_table");
		$stmt->execute();
		$res = $stmt->fetch();
		if ($res) {
			return $res;
		} else {
			return false;
		}
	}

	/**
	 *   UPDATE
	*/

	public function updateAboutContent($content)
	{
		$stmt = $this->link->prepare("UPDATE $this->about_table SET content=:content");
		$stmt->execute(['content' => $content]);
		if ($stmt) {
			return true;
		} else {
			return false;
		}
	}
}
?>