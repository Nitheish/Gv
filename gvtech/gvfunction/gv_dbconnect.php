<?
	$GLOBALS['_GVconn'] = null;
	
	if(!function_exists('MyDbConnect'))
	{
		function MyDbConnect()
		{
			$serverName = "localhost";
			$username = "69384a766858337562646936392b7677394d585767462f4e4365304d726f7849456739567a3878353662546c78467863693343536a77566970345a55736137423866443532757a43767a4631662f6d73473049566f673d3d";
			$password = "6d5a436761674c324e6c5a46426a67696f54596e346b58373753397a3134324f55695a4d744a4b6d793774594275706e32715a52732b3756716643794833764f377434627567742f7473323358564e77373268636c513d3d";
			$dbName = $GLOBALS['DB_NAME'];
	
			$GLOBALS['_GVconn'] = new mysqli($serverName, GVstringDecrption($username), GVstringDecrption($password), $dbName);
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