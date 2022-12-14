<?php

/* Conecta con la Base de datos mysql */



define ('LIKE','LIKE');

if (!isset($mysqlport)){
	$mysqlport = 3306;
}
global $db;	// declara al objeto base de datos como global
$db = mysqli_connect($host , $dbuser, $dbpassword,$dbname, $mysqlport);


mysqli_set_charset($db, "utf8");

//$varabc =  mysqli_client_encoding($db);
//printf("client encoding is %s\n", $varabc);


/* Comprueba la conexci?n */
if (mysqli_connect_errno()) {
	printf("La conexi?n ha fallado: %s\n", mysqli_connect_error());
	session_unset();
	session_destroy();
	echo '<p>Haga Click<a href="index.php">Aqui</a>para iniciar sesion nuevamente</p>';
	exit();
}

if ( !$db ) {
	echo '<BR>No hay informaci?n suficiente en el archivo config.php para realizar la correcta conexcion a la base de datos';
	exit;
}

/* 
//Update to allow RecurringSalesOrdersProcess.php to run via cron 
if (isset($DatabaseName)) {
        if (!mysqli_select_db($db,$DatabaseName)) {
            echo '<BR>' . _('The company name entered does not correspond to a database on the database server specified in the config.php configuration file. Try logging in with a different company name');  echo '<BR><A HREF="index.php">' . _('Back to login page') . '</A>';
                echo '<BR><A HREF="index.php">' . _('Back to login page') . '</A>';
                unset ($DatabaseName);
                exit;
        }
} else {
        if (!mysqli_select_db($db,$_SESSION['DatabaseName'])) {
            echo '<BR>' . _('The company name entered does not correspond to a database on the database server specified in the config.php configuration file. Try logging in with a different company name');  echo '<BR><A HREF="index.php">' . _('Back to login page') . '</A>';
                echo '<BR><A HREF="index.php">' . _('Back to login page') . '</A>';
                unset ($_SESSION['DatabaseName']);
                exit;
        }
}
*/
require_once ($PathPrefix .'includes/MiscFunctions.php');

//DB wrapper functions to change only once for whole application


function DB_query ($SQL,
					&$Conn,
					$ErrorMessage='',
					$DebugMessage= '',
					$Transaction=false,
					$TrapErrors=true){

	global $debug;
	global $PathPrefix;

// PeterMoulding.com
//20071102 Change from mysql to mysqli;
	//$result=mysql_query($SQL,$Conn);


	
	$result=mysqli_query($Conn, $SQL);
	$_SESSION['LastInsertId'] = mysqli_insert_id($Conn);

	if ($DebugMessage == '') {
		$DebugMessage = 'La Conexion con la base de datos se ha perdido';
	}

	if (DB_error_no($Conn) != 0 AND $TrapErrors==true){
		
		if ($TrapErrors){
			//require_once($PathPrefix . 'includes/header.inc');
		}
		prnMsg($ErrorMessage.'<br />' . DB_error_msg($Conn),'error', 'Database Error');
		if ($debug==1){
			prnMsg($DebugMessage. "<br />$SQL<br />",'error','Database SQL Failure');
		}
		
		if ($Transaction){
			$SQL = 'rollback';
			$Result = DB_query($SQL,$Conn);
			if (DB_error_no($Conn) !=0){
				prnMsg('Error Rolling Back Transaction', '', 'Database Rollback Error' );
			}
		}
		
		if ($TrapErrors){
			//include($PathPrefix . 'includes/footer.inc');
			exit;
		}
	} elseif (isset($_SESSION['MonthsAuditTrail']) and (DB_error_no($Conn)==0 AND $_SESSION['MonthsAuditTrail']>0)){

		$SQLArray = explode(' ', $SQL);

		
		if (($SQLArray[0] == 'INSERT')
			OR ($SQLArray[0] == 'UPDATE')
			OR ($SQLArray[0] == 'DELETE')) {

			if ($SQLArray[2]!='audittrail'){ // to ensure the auto delete of audit trail history is not logged
				$AuditSQL = "INSERT INTO audittrail (transactiondate,
									userid,
									querystring)
						VALUES('" . Date('Y-m-d H:i:s') . "',
							'" . trim($_SESSION['UserID']) . "',
							'" . DB_escape_string($SQL) . "')";

				$AuditResult = mysqli_query($Conn, $AuditSQL);
			}
		}
	}
	return $result;

}

function DB_fetch_row (&$ResultIndex) {

	$RowPointer=mysqli_fetch_row($ResultIndex);
	Return $RowPointer;
}

function DB_fetch_assoc (&$ResultIndex) {

	$RowPointer=mysqli_fetch_assoc($ResultIndex);
	Return $RowPointer;
}

function DB_fetch_array (&$ResultIndex) {

	$RowPointer=mysqli_fetch_array($ResultIndex);
	Return $RowPointer;
}

function DB_data_seek (&$ResultIndex,$Record) {
	mysqli_data_seek($ResultIndex,$Record);
}

function DB_free_result (&$ResultIndex){
	mysqli_free_result($ResultIndex);
}

function DB_num_rows (&$ResultIndex){
		return mysqli_num_rows($ResultIndex);
}

function DB_affected_rows(&$ResultIndex){

	global $db;
	return mysqli_affected_rows($db);

}

function DB_error_no (&$Conn){
	return mysqli_errno($Conn);
}

function DB_error_msg(&$Conn){
	return mysqli_error($Conn);
}

function DB_Last_Insert_ID(&$Conn,$table, $fieldname){
//	return mysqli_insert_id($Conn);
	if (isset($_SESSION['LastInsertId'])) {
		$Last_Insert_ID = $_SESSION['LastInsertId'];
	} else {
		$Last_Insert_ID = 0;
	}
//	unset($_SESSION['LastInsertId']);
	return $Last_Insert_ID;
}

function DB_escape_string($String){
	global $db;
	return mysqli_real_escape_string($db, htmlspecialchars($String, ENT_COMPAT,'utf-8'));
}

function DB_show_tables(&$Conn){
	$Result = DB_query('SHOW TABLES',$Conn);
	Return $Result;
}

function DB_show_fields($TableName, &$Conn){
	$Result = DB_query("DESCRIBE $TableName",$Conn);
	Return $Result;
}

function interval( $val, $Inter ){
		global $dbtype;
		return "\n".'interval ' . $val . ' '. $Inter."\n";
}

function DB_Maintenance($Conn){

	prnMsg(_('The system has just run the regular database administration and optimisation routine.'),'info');

	$TablesResult = DB_query('SHOW TABLES',$Conn);
	while ($myrow = DB_fetch_row($TablesResult)){
		$Result = DB_query('OPTIMIZE TABLE ' . $myrow[0],$Conn);
	}

	$Result = DB_query("UPDATE config
				SET confvalue='" . Date('Y-m-d') . "'
				WHERE confname='DB_Maintenance_LastRun'",
				$Conn);
}

function DB_Txn_Begin($Conn){
	mysqli_query($Conn,'SET autocommit=0');
	mysqli_query($Conn,'START TRANSACTION');
}

function DB_Txn_Commit($Conn){
	mysqli_query($Conn,'COMMIT');
	mysqli_query($Conn,'SET autocommit=1');
}

function DB_Txn_Rollback($Conn){
	mysqli_query($Conn,'ROLLBACK');
}
function DB_IgnoreForeignKeys($Conn){
	mysqli_query($Conn,'SET FOREIGN_KEY_CHECKS=0');
}
function DB_ReinstateForeignKeys($Conn){
	mysqli_query($Conn, 'SET FOREIGN_KEY_CHECKS=1');
}

?>
