<?
	$GLOBALS['_GVconn'] = null;
	$GLOBALS['DB_NAME'] = "gvcollection";
	if(!function_exists('MyDbConnect'))
	{
		function MyDbConnect()
		{
			$serverName = "localhost";
			$username = "root";
			$password = "";
			$dbName = $GLOBALS['DB_NAME'];
	
			$GLOBALS['_GVconn'] = new mysqli($serverName,$username, $password, $dbName);
		}
	}
	
	if(!function_exists('MyDbClose'))
	{
		function MyDbClose()
		{
			mysqli_close($GLOBALS['_GVconn']);
		}
	}
	
	if(!function_exists('MyDbQuery'))
	{
		function MyDbQuery($GVquery, $GVparamTypeValArr)
		{
			$_GVresultSet = array();
			
			$_GVtypeValArr = MYSQL_ParamTypeVal($GVparamTypeValArr);
			
			$GVparamType = $_GVtypeValArr["_PARAMTYPE"];
			$GVparamValue = $_GVtypeValArr["_PARAMVAL"];
			
			if($GLOBALS['_GVconn']) 
			{
				if($GVqueryStmt = $GLOBALS['_GVconn']->prepare($GVquery))
				{
					MYSQL_BindQueryParams($GVqueryStmt, $GVparamType, $GVparamValue);
					mysqli_stmt_execute($GVqueryStmt);
					$_GVresultSet = mysqli_stmt_get_result($GVqueryStmt);
					mysqli_stmt_close($GVqueryStmt);
				}
				else
				{
					echo "ERROR: Could not prepare query: $GVquery. " . $GLOBALS['_GVconn']->error;
				}
				
				$GLOBALS['_GVParamArray'] = array();
				
				return $_GVresultSet;
			}
			else
			{
				 die("ERROR: Could not connect. " . mysqli_connect_error());
			}
		}
	}
	
	if(!function_exists('MyDbFreeResult'))
	{
		function MyDbFreeResult($GVresultSet)
		{
			return mysqli_free_result($GVresultSet);
		}
	}
	
	if(!function_exists('MyDbNumRows'))
	{
		function MyDbNumRows($GVresultSet)
		{
			return mysqli_num_rows($GVresultSet);
		}
	}
	
	if(!function_exists('GVgetQueryString'))
	{
		function GVgetQueryString($GVparamTypeValArr)
		{
			$outParamArr = array();
			$outParamArr['_INSERT_SQLQRY_FIELDS'] = "";
			$outParamArr['_INSERT_SQLQRY_VAL'] = "";
			$outParamArr['_UPDATE_SQLQRY_VAL'] = "";
			
			foreach($GVparamTypeValArr as $GVparamKey=>$paramArrVal)
			{
				$outParamArr['_INSERT_SQLQRY_FIELDS'] .= $paramArrVal["KEY"].",";
				$outParamArr['_INSERT_SQLQRY_VAL'] .= "?,";
				
				if($paramArrVal["TYPE"] == "SKIP")
				{
					$outParamArr['_UPDATE_SQLQRY_VAL'] .= $paramArrVal["KEY"]."=".$paramArrVal["VAL"].",";
				}
				else
					$outParamArr['_UPDATE_SQLQRY_VAL'] .= $paramArrVal["KEY"]."=?,";
			}
			
			$outParamArr['_INSERT_SQLQRY_FIELDS'] = substr($outParamArr['_INSERT_SQLQRY_FIELDS'],0,-1);
			$outParamArr['_INSERT_SQLQRY_VAL'] = substr($outParamArr['_INSERT_SQLQRY_VAL'],0,-1);
			$outParamArr['_UPDATE_SQLQRY_VAL'] = substr($outParamArr['_UPDATE_SQLQRY_VAL'],0,-1);
			
			return $outParamArr;
		}
	}
	
	if(!function_exists('MYSQL_BindQueryParams'))
	{
		function MYSQL_BindQueryParams($GVqueryStmt, $GVparamType, $GVparamValueArr) 
		{
			$paramVALRef[] = & $GVparamType;
			
			for($paramCNT = 0;$paramCNT < count($GVparamValueArr); $paramCNT++) 
			{
				$paramVALRef[] = & $GVparamValueArr[$paramCNT];
			}
			
			call_user_func_array(array($GVqueryStmt,'bind_param'), $paramVALRef);
		}
	}
	
	if(!function_exists('MYSQL_BuildArray'))
	{
		function MYSQL_BuildArray($_KEY, $_VAL, $_TYPE)
		{
			$_GVParamArray = & $GLOBALS['_GVParamArray'];
			
			if(is_array($_VAL) && count($_VAL) > 0)
			{
				foreach($_VAL as $_VALARR_KEY=>$_VALARR_VAL)
				{
					$_paramArr = array();
					$_paramArr["KEY"] = $_KEY;
					$_paramArr["VAL"] = $_VALARR_VAL;
					$_paramArr["TYPE"] = $_TYPE;
					$_GVParamArray[] = $_paramArr;
				}
			}
			else
			{
				$_paramArr = array();
				$_paramArr["KEY"] = $_KEY;
				$_paramArr["VAL"] = $_VAL;
				$_paramArr["TYPE"] = $_TYPE;
				
				$_GVParamArray[] = $_paramArr;
			}
		}
	}
	
	if(!function_exists('MYSQL_ParamTypeVal'))
	{
		function MYSQL_ParamTypeVal($GVparamTypeValArr)
		{
			$outParamArr = array();
			$outParamVALUEArr = array();
			$outParamArr['_PARAMTYPE'] = "";
			$outParamArr['_PARAMVAL'] = array();
			
			foreach($GVparamTypeValArr as $paramArrVal)
			{
				if($paramArrVal["TYPE"] != "SKIP")
				{
					if(is_array($paramArrVal["VAL"]) && count($paramArrVal["VAL"]) > 0)
					{
						foreach($paramArrVal["VAL"] as $_VALARR_KEY=>$_VALARR_VAL)
						{
							$outParamArr['_PARAMTYPE'] .= $paramArrVal["TYPE"];
							$outParamVALUEArr[] = $_VALARR_VAL;
						}
					}
					else
					{
						$outParamArr['_PARAMTYPE'] .= $paramArrVal["TYPE"];
						$outParamVALUEArr[] = $paramArrVal["VAL"];
					}
				}
			}
			
			$outParamArr['_PARAMVAL'] = $outParamVALUEArr;
			
			return $outParamArr;
		}
	}
	
	if(!function_exists('MYSQLPrepareQuery'))
	{
		function MYSQLPrepareQuery($qryStr)
		{
			$executeQry = "";
			$_GVtypeValArr = MYSQL_ParamTypeVal($GLOBALS["_GVParamArray"]);
			$GVparamValue = $_GVtypeValArr["_PARAMVAL"];
			
			$tokenKey = strtok($qryStr, "?");
	 		
	 		$paramCnt = 0;
			while ($tokenKey !== false)
			{
				$executeQry .= $tokenKey."'".$GVparamValue[$paramCnt]."'";
				$tokenKey = strtok("?");
				$paramCnt++;
			}
			
			echo $executeQry;
		}
	}
	
	if(!function_exists('MYSQL_ArrayBuild_String'))
	{
		function MYSQL_ArrayBuild_String($_buildStrArray)
		{
			if(is_array($_buildStrArray) && count($_buildStrArray) > 0)
				return substr(str_repeat('?,',count($_buildStrArray)),0,-1);
			else
				return "";
		}
	}
?>