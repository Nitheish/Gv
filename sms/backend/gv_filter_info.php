<?
	if($FILTER_OPTION == "SAVE")
	{
		if($_POST || $FILTER_FORCE_IND == 1)
		{
			foreach($FILTER_ARR as $filter_name=>$filter_val)
			{
				$MySelectQry = "select company_id from gv_filter_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and gv_login_id=?";MYSQL_BuildArray("gv_login_id",$gv_login_id,"s");
				$MySelectQry .= " and page_name=?";MYSQL_BuildArray("page_name",$page_name,"s");
				$MySelectQry .= " and filter_name=?";MYSQL_BuildArray("filter_name",$filter_name,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				$MyNumRows = MyDbNumRows($MyDbResult);
				MyDbFreeResult($MyDbResult);
				
				if($MyNumRows == 0)
				{
					$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"gv_login_id", "VAL"=>$gv_login_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"page_name", "VAL"=>$page_name, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"filter_name", "VAL"=>$filter_name, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"filter_val", "VAL"=>$filter_val, "TYPE"=>"s");
					$outParamArr = GVgetQueryString($_GVParamArray);
					
					$MyInsertQry = "insert into gv_filter_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
					MyDbQuery($MyInsertQry, $_GVParamArray);
				}
				else
				{
					$_GVParamArray[] = array("KEY"=>"filter_val", "VAL"=>$filter_val, "TYPE"=>"s");
					$outParamArr = GVgetQueryString($_GVParamArray);
					
					$MyUpdateQry = "update gv_filter_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
					$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MyUpdateQry .= " and gv_login_id=?";MYSQL_BuildArray("gv_login_id",$gv_login_id,"s");
					$MyUpdateQry .= " and page_name=?";MYSQL_BuildArray("page_name",$page_name,"s");
					$MyUpdateQry .= " and filter_name=?";MYSQL_BuildArray("filter_name",$filter_name,"s");
					MyDbQuery($MyUpdateQry, $_GVParamArray);
				}
			}
			
			$FILTER_FORCE_IND = 0;
		}
		
		$MySelectQry = "select filter_name,filter_val from gv_filter_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and gv_login_id=?";MYSQL_BuildArray("gv_login_id",$gv_login_id,"s");
		$MySelectQry .= " and page_name=?";MYSQL_BuildArray("page_name",$page_name,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC))
		{
			$filter_name = GVStringFormat($MyRowData['filter_name']);
			$filter_val = GVStringFormat($MyRowData['filter_val']);
			${$filter_name} = $filter_val;
		}
		MyDbFreeResult($MyDbResult);
	}
	else if($FILTER_OPTION == "DELETE")
	{
		$MyDeleteQry = "delete from customer where ";
		$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MyDeleteQry .= " and gv_login_id=?";MYSQL_BuildArray("gv_login_id",$gv_login_id,"s");
		$MyDeleteQry .= " and page_name=?";MYSQL_BuildArray("page_name",$page_name,"s");
		MyDbQuery($MyDeleteQry, $_GVParamArray);
	}
?>