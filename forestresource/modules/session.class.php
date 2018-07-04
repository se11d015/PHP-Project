<?php
class SecureSession
{

	public function __construct()
	{
		session_start();
	}
	
	public function isregistered($name)
	{
		if (isset($_SESSION[$name]))
		{
			return true;
		}
		return false;
	}
	
	public function get($name)
	{
		return $_SESSION[$name];
	}

	public function set($name, $value)
	{
		$_SESSION[$name] = $value;      
		return true;
	}
	
	public function deleteset($name)
	{
		unset($_SESSION[$name]);      
		return true;
	}
}
?>
