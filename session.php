<?php 

class Session{	
	public static function init(){
		if (session_id() == "") {
			session_start();
		}
	}

	public static  function set($key,$val){
		$_SESSION[$key]=$val;
	}
	
	public static function get($key){
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}else{
			return "0";
		}
	}
	public static function destroy(){
		session_unset();
		session_destroy();
		header('location:index.php');
	}
}
?>