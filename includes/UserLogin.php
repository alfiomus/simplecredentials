<?php

/*  Performs login checks and $_SESSION initialisation */
/* $Id: UserLogin.php 4468 2011-01-15 00:57:20Z daintree $*/

define('UL_OK',  0);		/* User verified, session initialised */
define('UL_NOTVALID', 1);	/* User/password do not agree */
define('UL_BLOCKED', 2);	/* Account locked, too many failed logins */
define('UL_CONFIGERR', 3);	/* Configuration error in webERP or server */
define('UL_SHOWLOGIN', 4);
define('UL_MAINTENANCE', 5);

/*	UserLogin
 *  Function to validate user name,  perform validity checks and initialise
 *  $_SESSION data.
 *  Returns:
 *	See define() statements above.
 */

function userLogin($Name, $Password, $db) {

	global $debug;

	if (!isset($_SESSION['AccessLevel']) OR $_SESSION['AccessLevel'] == '' OR
		(isset($Name) AND $Name != '')) {
	/* if not logged in */
		$_SESSION['AccessLevel'] = '';
		$_SESSION['CustomerID'] = '';
		$_SESSION['UserBranch'] = '';
		$_SESSION['SalesmanLogin'] = '';
		$_SESSION['Module'] = '';
		$_SESSION['PageSize'] = '';
		$_SESSION['UserStockLocation'] = '';
		$_SESSION['AttemptsCounter']++;
		// Show login screen
		if (!isset($Name) or $Name == '') {
			return  UL_SHOWLOGIN;
		}
		$sql = "SELECT *
						FROM sg001
						WHERE USUARIO='" . $Name . "'
						AND CLAVE='" . $Password . "'";
		$ErrMsg = 'No se pudo obtener los datos de acceso del usuario';
		$debug =1;
		$Auth_Result = DB_query($sql, $db,$ErrMsg);
		// Populate session variables with data base results
		if  (DB_num_rows($Auth_Result) > 0){ 
			$myrow = DB_fetch_array($Auth_Result);
			/*
			if ($myrow['blocked']==1){
			//the account is blocked
				return  UL_BLOCKED;
			}*/
			/*reset the attempts counter on successful login */
			$_SESSION['USUARIO'] = $myrow['USUARIO'];
			$_SESSION['AttemptsCounter'] = 0;
			$_SESSION['AccessLevel'] = $myrow['acceso'];
			//$_SESSION['CustomerID'] = $myrow['customerid'];
			//$_SESSION['UserBranch'] = $myrow['branchcode'];
			//$_SESSION['DefaultPageSize'] = $myrow['pagesize'];
			//$_SESSION['UserStockLocation'] = $myrow['defaultlocation'];
			$_SESSION['MAIL'] = $myrow['MAIL'];
			$_SESSION['modulosactivos'] = explode(",", $myrow['MODULOSACTIVOS']);
			$_SESSION['NOMBRE'] = $myrow['NOMBRE'];
			$_SESSION['AllowedPageSecurityTokens'] = 1 ;
			//$_SESSION['Theme'] = $myrow['theme'];
			//$_SESSION['Language'] = $myrow['language'];
			//$_SESSION['SalesmanLogin'] = $myrow['salesman'];
			/*
			if (isset($myrow['pdflanguage'])) {
				$_SESSION['PDFLanguage'] = $myrow['pdflanguage'];
			} else {
				$_SESSION['PDFLanguage'] = '0'; //default to latin western languages
			}*/

			/*
			if ($myrow['displayrecordsmax'] > 0) {
				$_SESSION['DisplayRecordsMax'] = $myrow['displayrecordsmax'];
			} else {
				$_SESSION['DisplayRecordsMax'] = $_SESSION['DefaultDisplayRecordsMax'];  // default comes from config.php
			}*/

			/*
			$sql = "UPDATE SG001 SET TIPO=1
							WHERE www_users.userid='" . $Name . "'";
			$Auth_Result = DB_query($sql, $db);
			
			//get the security tokens that the user has access to 
			$sql = "SELECT tokenid FROM securitygroups
							WHERE secroleid =  '" . $_SESSION['AccessLevel'] . "'";
			$Sec_Result = DB_query($sql, $db);
			$_SESSION['AllowedPageSecurityTokens'] = array();
			if (DB_num_rows($Sec_Result)==0){
				return  UL_CONFIGERR;
			} else {
				$i=0;
				while ($myrow = DB_fetch_row($Sec_Result)){
					$_SESSION['AllowedPageSecurityTokens'][$i] = $myrow[0];
					$i++;
				}
			}
			//  Temporary shift - disable log messages - how temporary?
			*/
		} else { 	// Incorrect password
			// 5 login attempts, show failed login screen
			if (!isset($_SESSION['AttemptsCounter'])) {
				$_SESSION['AttemptsCounter'] = 0;
			} elseif ($_SESSION['AttemptsCounter'] >= 5 AND isset($Name)) {
				//User blocked from future accesses until sysadmin releases 
				/*
				$sql = "UPDATE www_users
							SET blocked=1
							WHERE www_users.userid='" . $Name . "'";
				$Auth_Result = DB_query($sql, $db);
				*/
				return  UL_BLOCKED;
			}
			return  UL_NOTVALID;
		}
	}		// End of userid/password check
	// Run with debugging messages for the system administrator(s) but not anyone else

	return   UL_OK;		    /* All is well */
}

?>