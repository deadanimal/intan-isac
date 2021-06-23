<?php
//FALCON V2 CONFIGURATION FILE

//db configurations
define('DBMS_NAME','mysql');				//mysql/oracle
define('DB_CONNECTION','10.1.3.87');		//for mysql only
define('DB_DATABASE','isac');
define('DB_USERNAME','isac_gsql');
define('DB_PASSWORD','isac2009');
define('DB_OTHERS','usr_isac');
define('KOD_IAC','01');

//constants definition
define('SESSION_NAME','FAREEDA_DEMO');
define('SYSTEM_NAME','FAREEDA_DEMO');
define('SYSTEM_FULL_NAME','ISAC INTAN');
define('SYSTEM_VERSION','2.2');
define('SYSTEM_BUILD','1009');
define('SYSTEM_BACKUP_FOLDER','system_backup');
define('SYSTEM_BACKUP_FILE_PREFIX',SYSTEM_NAME);
define('SYSTEM_BACKUP_EXCLUDE_FOLDER','system_backup');
define('MENU_DEFAULT',1);												//0 for expand, 1 for compress
define('DEFAULT_DATE_FORMAT','format-d-m-y');							//format-y-m-d, format-d-m-y		YYYY-MM-DD, DD-MM-YYYY
define('DEFAULT_QUERY_LIMIT',1000);                                     //max row of query result
define('DEFAULT_REFERENCE_PAGING',15);                                  //max row of reference
define('LIMIT_TO_FIREFOX_2',false);

define('SYSTEM_HOME_PAGE','index.php?page=dashboard&dashid=1');

//--------SUB HEADER------------------------------------------------------
define('HOME_PAGE','Muka Utama');
define('HOME_PAGE_URL','index.php');
define('LOGOUT','Log Keluar');
define('LOGOUT_URL','login.php?mode='.$_SESSION['loginMode']);
//--------SUB HEADER------------------------------------------------------

//--------VERSIONING OPTIONS----------------------------------------------
define('VERSIONING_FOLDER_NAME','xml_backup');
define('VERSIONING_COUNT',5);
define('VERSIONING_AUTOSAVE',true);
//--------EOF VERSIONING OPTIONS------------------------------------------

//--------LOGIN OPTIONS---------------------------------------------------
define('SYSTEM_LOGIN_DEFAULT','login_default.php');
define('SYSTEM_LOGIN_CUSTOM','login_custom.php');
define('SYSTEM_LOGIN_CAS','login_cas.php');
define('SYSTEM_LOGIN_WEB_AUTHENTICATION','login_web_authentication.php');
//--------//LOGIN OPTIONS-------------------------------------------------

//--------LOGIN SCREEN---------------------------------------------------
define('SYSTEM_LOGIN_PAGE',SYSTEM_LOGIN_CUSTOM);
define('LOGIN_ERROR_MSG','Sila isikan Nama Pengguna dan Kata Laluan anda.');	//login error msg
define('LOGIN_INVALID_MSG','Ralat! Nama Pengguna atau Kata Laluan yang diberi tidak tepat.');	//login error msg
define('LOGIN_ACCOUNT_USED_MSG','Ralat! Akaun sedang digunakan. Sila cuba sebentar lagi.');
define('LOGIN_PASSWORD_EXPIRED','Ralat! Kata laluan telah melepasi tarikh luput.');
define('LOGIN_PASSWORD_ALMOST_EXPIRED','Ralat! Kata laluan hampir melepasi tarikh luput. Tukar kata laluan?');
define('LOGIN_SYS_NAME_ENABLED',true);
define('LOGIN_FALCON_CREDIT','Powered by Fareeda AE v'.SYSTEM_VERSION.' Build '.SYSTEM_BUILD);
//--------//LOGIN SCREEN-------------------------------------------------

//--------CAS SETTING----------------------------------------------------
define('CAS_ENABLED',false);				//cas enable flag
define('CAS_VERSION',2);					//cas version
define('CAS_HOSTNAME','localhost');			//cas host name (domain)
define('CAS_PORT',8443);					//cas port
define('CAS_URI','cas');					//cas uri (folder name for cas)
define('LOGIN_CAS_MSG','Sila log masuk untuk melihat sistem!');	//cas login error msg
//--------//CAS SETTING--------------------------------------------------

//--------PASSWORD EXPIRY OPTIONS---------------------------------------------------
define('PASSWORD_EXPIRY',false);
define('PASSWORD_EXPIRY_DAYS',1);
define('PASSWORD_EXPIRY_REMINDER_DAYS',1);
define('CHANGE_PASSWORD_URL','index.php?page=change_password&menuID=12');
//--------//PASSWORD EXPIRY OPTIONS-------------------------------------------------

// FOR FAIS KEEP HISTORY OF THE NOTIFICATION //
define('NOTIFICATION_HISTORY', 'ENABLE'); 		//ENABLE, DISABLE
define('NOTIFICATION_HISTORY_DAYS', 365); 		//In days
define('NOTIFICATION_HISTORY_FILENAME', './notification/noti_his.his');
define('NOTIFICATION_HISTORY_DELETE', 'YES'); //YES, NO. To delete history data after backup


//--------ERROR MESSAGES-------------------------------------------------
define('FILE_NOT_EXIST_ERR','Error. The file requested does not exist.');
define('JAVASCRIPT_NOT_ENABLED_ERR','Please enable JavaScript.');
define('COOKIE_NOT_ENABLED_ARR','Please enable cookie.');
//--------//ERROR MESSAGES-----------------------------------------------

//-------LAYOUT----------------------------------------------------------
//left menu
define('LEFT_MENU_ENABLED',true);									//true/false
define('LEFT_MENU_WIDTH',250);					//in pixels. ref: side_menu_left.php
define('LEFT_MENU_CLASS','');
define('LEFT_MENU_ID','sideMenu_1');
define('LEFT_MENU_FILENAME','side_menu_left.php');
define('NO_LEFT_MENU_NOTIFICATION','You are not permissioned to view any menu! Please contact System Administrator!');

//right menu
define('RIGHT_MENU_ENABLED',false);				//true/false
define('RIGHT_MENU_WIDTH',200);					//in pixels
define('RIGHT_MENU_CLASS','');
define('RIGHT_MENU_ID','sideMenu_2');
define('RIGHT_MENU_FILENAME','side_menu_right.php');
define('NO_RIGHT_MENU_NOTIFICATION','You are not permissioned to view any menu! Please contact System Administrator!');

//footer
define('FOOTER_ENABLED',false);					//true/false
define('FOOTER_TEXT','Copyright 2009. Ori Network Sdn Bhd');
define('FOOTER_CLASS','');
define('FOOTER_ID','footer');

//bottom links
define('BOTTOM_LINKS_ENABLED',false);			//true/false
define('BOTTOM_LINKS_CLASS','');
define('BOTTOM_LINKS_ID','bottomLinks');

//bottom text
define('BOTTOM_TEXT_ENABLED',false);				//true/false
define('BOTTOM_TEXT_CLASS','');
define('BOTTOM_TEXT_ID','bottomText');
define('BOTTOM_TEXT_TEXT','Powered by Project Code Fareeda AE v'.SYSTEM_VERSION.' Build '.SYSTEM_BUILD);

//page response time
define('PAGE_GENERATION_TIME_ENABLED',true);
define('PAGE_RESPONSE_ENABLED',false);
define('PAGE_RESPONSE_CLASS','');
define('PAGE_RESPONSE_ID','pageGeneration');

//block
define('HEADER_ENABLED',true);					//true/false
define('SUB_HEADER_ENABLED',true);				//true/false
define('PROFILE_ENABLED',true);				//true/false

//-------//LAYOUT-------------------------------------------------------

//------CHANGE PASSWORD SCREEN------------------------------------------
define('CPWD_MIN_LENGTH',3);
define('CPWD_MSG_ERR_1','Ralat! Kata laluan semasa tidak tepat. Sila cuba sekali lagi. ');
define('CPWD_MSG_ERR_2','Ralat! Kata laluan baru tidak sama. Sila cuba sekali lagi. ');
define('CPWD_MSG_ERR_3','Ralat! Pastikan kata laluan lebih dari '.CPWD_MIN_LENGTH.' aksara.');
define('CPWD_MSG_SUCCESS','Kata laluan telah berjaya dikemaskini.');
//------//END CHANGE PASSWORD SCREEN------------------------------------

//------STANDARD DATABASE NOTIFICATION MESSAGE--------------------------
define('DB_INSERT_SUCCESS','Maklumat telah berjaya dimasukkan.');
define('DB_UPDATE_SUCCESS','Maklumat telah berjaya dikemaskini.');
define('DB_DELETE_SUCCESS','Maklumat telah berjaya dihapuskan.');

define('DB_INSERT_SUCCESS_ENGLISH','Data is successfully inserted.');
define('DB_UPDATE_SUCCESS_ENGLISH','Data is successfully updated.');
define('DB_DELETE_SUCCESS_ENGLISH','Data is successfully deleted.');

//------END STANDARD DATABASE NOTIFICATION MESSAGE----------------------

//------STANDARD DATABASE MESSAGE ERROR---------------------------------
define('DB_INSERT_ERR','Maklumat tidak berjaya dimasukkan ke dalam pengkalan data.');
define('DB_UPDATE_ERR','Maklumat tidak berjaya dikemaskini ke dalam pengkalan data.');
define('DB_DELETE_ERR','Maklumat tidak berjaya dihapuskan dari pengkalan data.');

define('DB_INSERT_ERR_ENGLISH','Insertion of data into the database has failed.');
define('DB_UPDATE_ERR_ENGLISH','Updating of data in the database has failed.');
define('DB_DELETE_ERR_ENGLISH','Deletion of data from the database has failed.');
//------END STANDARD DATABASE MESSAGE ERROR-----------------------------

//------TABULAR ADD / DELETE ROW----------------------------------------
define('ADD_ROW_COUNT',30);
define('ADD_ROW','Tambah Rekod');
define('DELETE_ROW','Buang Baris');
define('ADD_ROW_ENGLISH','Add Row');
define('DELETE_ROW_ENGLISH','Delete Row');
//------END TABULAR ADD / DELETE ROW------------------------------------

?>