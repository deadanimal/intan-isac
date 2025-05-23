<?php 
//--------------------------------------------------------------------------------------------------
// CLASS NAME: mySessionMgmt [ COMPLETED ]
// BASE CLASS: -
// DESCRIPTION: To provide session management
// METHODS: __construct, logout, redirect, sexExpiryTime, getSessionName
//--------------------------------------------------------------------------------------------------

//USAGE SYNTAX
//$mySession->logout();							//destroy session
//$mySession->redirect("index.php");			//redirect to page
//$mySession->setExpiryTime(15);				//in minutes
//$mySession->getSessionName();					//return session name

//class for session management
class mySessionMgmt
{
	//class member declaration
	private $sessionName;		//session name
	private $redirectPath;		//file to redirect
	private $expiryTime; 		//in minutes

	//-----------------------------------------
	//| start class methods declaration block |
	//-----------------------------------------
		
	//to create session (php 5 constructor)
	public function __construct($session)
	{	
		//set session name 
		$this->sessionName = $session;
		
		//set session name
		session_name($this->sessionName);					
		
		//regenerate id
		session_regenerate_id();					
		
		//write close
		session_write_close();						
		
		//start the session
		session_start();
	}
	
	//to logout and clear session
	public function logout()
	{	
		//clear session array		
		$_SESSION = array();								
		
		//create cookie
		if (isset($_COOKIE[session_name()])) 
			setcookie(session_name(), '', time()-42000, '/');
		
		//destroy session
		session_destroy();			
	}
	
	//to redirect after logging out
	public function redirect($redirectPath)
	{
		$path = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$redirectPath;
    	echo"<script>window.location=\"".$path."\"</script>";
	}
	
	//set expiry time for cache
	public function setExpiryTime($expiryTime)
	{	
		//session_cache_limiter('private');
		//$cache_limiter = session_cache_limiter();
	
		//set expiry time in minutes
		session_cache_expire($this->expiryTime);
	}
	
	//get session name
	public function getSessionName()
	{	
		//return the session name
		return $this->sessionName;
	}
	
	//-----------------------------------------
	//| end class methods declaration block   |
	//-----------------------------------------
}
?>