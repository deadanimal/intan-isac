<?php
//class CAS
class CAS
{
	//attribute
	private $casOnlineUser;
	private $casIsAuthenticated;
	
	public function __construct($version, $hostname, $port, $uri, $gateway=false)
	{
		//CAS client for php (make sure CAS server is up and running in order for login to function)
		include('tools/phpCAS/CAS/CAS.php');
		
		//switch version
		switch($version)
		{
			case 1: $version=CAS_VERSION_1_0; break;
			case 2: $version=CAS_VERSION_2_0; break;
		}//eof switch
		
		// set debug mode
		phpCAS::setDebug();
		
		// initialize phpCAS
		phpCAS::client($version,$hostname,$port,$uri,$gateway);
		
		// no SSL validation for the CAS server
		phpCAS::setNoCasServerValidation();
		
		// handle incoming logout requests
		phpCAS::handleLogoutRequests();
		
		// check CAS authentication
		if(phpCAS::checkAuthentication())
		{
			$this->casIsAuthenticated = true;				//set authentication status
			$this->casOnlineUser = phpCAS::getUser();		//set online user as username from cas server
		}//eof if
	}//eof function
	
	//get cas authentication status
	public function casIsAuthenticated()
	{
		return $this->casIsAuthenticated;
	}//eof function
	
	//get cas online user
	public function casOnlineUser()
	{
		return $this->casOnlineUser;
	}//eof function
	
	//redirect to login page
	public function casLogin()
	{
		phpCAS::forceAuthentication();
	}//eof function
	
	//redirect to logout page
	public function casLogout()
	{
		phpCAS::logout();
	}//eof function
}//eof class
?>