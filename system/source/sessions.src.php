<?php

if(!defined('SYS_STARTED')) die('Security activated');

	/*
	*	irasymas i sesija
	*/
  function write_session($key, $value)
  {
    $_SESSION[$key] = $value;
  }

	/*
	* sesijos nuskaitymas
	*/
  function read_session($key)
  {
    if (isset($_SESSION[$key])) 
		{
      return $_SESSION[$key];
    } 
		else 
		{
			return false;
    }
	}
    
	/*
	* sesijos istrynimas
	*/
  function remove_session($key)
  {
    if (isset($_SESSION[$key])) 
		{
			unset($_SESSION[$key]);
    }
	}    
		
	/*
	* sesijos patikrinimas -> atvaizdavimas -> istrynimas
	*/
	function uni_session($key)
	{
		if (isset($_SESSION[$key])) 
		{
			echo $_SESSION[$key];
			unset($_SESSION[$key]);
     }
		else
		{
			return false;
		}
	}

?>