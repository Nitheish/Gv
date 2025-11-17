<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
		
		$LoadHtmlPage = "gv_department_info";
		$ErrorInd = 0;
		
		$txtDepartmentName  = GVfixedInputText($txtDepartmentName);
		$txtDescription     = GVfixedInputText($txtDescription);
		
		if(strlen($txtDepartmentName) == 0)
			GVSetErrorCodes("txtDepartmentName","Please enter the Department Name");
		
		$MySelectQry = "select department_id from department_info where";
		$MySelectQry .= " company_id=?"; MYSQL_BuildArray("company_id",$company_id,"s");
		
		if($GVSTEP == "EDIT") 
		{
			$MySelectQry .= " and department_id!=?"; MYSQL_BuildArray("department_id",$GVID,"s");
		}
		
		$MySelectQry .= " and department_name=?"; MYSQL_BuildArray("department_name",$txtDepartmentName,"s");
		$MyDbResult = MyDbQuery($MySelectQry,$_GVParamArray);	
		$MyNumRows  = MyDbNumRows($MyDbResult);
		MyDbFreeResult($MyDbResult);
		
		if($MyNumRows > 0) 
		{
			GVSetErrorCodes("txtDepartmentName","Department name already exists. Please try a different one");
		}
		
		if($ErrorInd == 0)
		{
			if($GVSTEP == "ADD")
			{
			    $_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
			    $_GVParamArray[] = array("KEY"=>"department_name", "VAL"=>$txtDepartmentName, "TYPE"=>"s");
			    $_GVParamArray[] = array("KEY"=>"description", "VAL"=>$txtDescription, "TYPE"=>"s");
			
			    $outParamArr = GVgetQueryString($_GVParamArray);
			
			    $MyInsertQry = "insert into department_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
			    MyDbQuery($MyInsertQry, $_GVParamArray);
			
			    $MySelectQry = "select max(department_id) as MaxId from department_info where";
			    $MySelectQry .= " company_id=?"; MYSQL_BuildArray("company_id",$company_id,"s");
			    $MyDbResult = MyDbQuery($MySelectQry,$_GVParamArray);	
			    if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			    {
			        $GVID = GVStringFormat($MyRowData['MaxId']);
			    }
			    MyDbFreeResult($MyDbResult);
			
			    $deptCode = "DP".$GVID;
			    $_GVParamArray[] = array("KEY"=>"department_code", "VAL"=>$deptCode, "TYPE"=>"s");
			
			    $outParamArr = GVgetQueryString($_GVParamArray);
			
			    $MyUpdateQry = "update department_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			    $MyUpdateQry .= " company_id=?"; MYSQL_BuildArray("company_id",$company_id,"s");
			    $MyUpdateQry .= " and department_id=?"; MYSQL_BuildArray("department_id",$GVID,"s");
			    MyDbQuery($MyUpdateQry, $_GVParamArray);
			
			    $GVSTEP = "EDIT";
			}
			else
			{
			    $_GVParamArray[] = array("KEY"=>"department_name", "VAL"=>$txtDepartmentName, "TYPE"=>"s");
			    $_GVParamArray[] = array("KEY"=>"description", "VAL"=>$txtDescription, "TYPE"=>"s");
			
			    $outParamArr = GVgetQueryString($_GVParamArray);
			
			    $MyUpdateQry = "update department_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			    $MyUpdateQry .= " company_id=?"; MYSQL_BuildArray("company_id",$company_id,"s");
			    $MyUpdateQry .= " and department_id=?"; MYSQL_BuildArray("department_id",$GVID,"s");
			    MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			
			GVPopSaveLoad();
		}
		else
		{
			include("../html/".$LoadHtmlPage.".html");
		}
		
		include("gv_footer.php");
	}
?>
