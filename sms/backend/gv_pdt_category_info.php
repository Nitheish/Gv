<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_pdt_category_info";
		$ErrorInd = 0;
		
		$txtCategoryName = GVfixedInputText($txtCategoryName);
		
		if(strlen($txtCategoryName) == 0)
			GVSetErrorCodes("txtCategoryName","Please enter the Product Category Name");
		
		$MySelectQry = "select pdt_category_id from pdt_category_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		
		if($GVSTEP == "EDIT")
		{
			$MySelectQry .= " and pdt_category_id!=?";MYSQL_BuildArray("pdt_category_id",$GVID,"s");
		}
		
		$MySelectQry .= " and category_name=?";MYSQL_BuildArray("category_name",$txtCategoryName,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		$MyNumRows = MyDbNumRows($MyDbResult);
		MyDbFreeResult($MyDbResult);
		
		if($MyNumRows > 0)
		{
			GVSetErrorCodes("txtCategoryName","Product category name already exists.Please try different one");
		}
		
		if($ErrorInd == 0)
		{
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"category_name", "VAL"=>$txtCategoryName, "TYPE"=>"s");
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into pdt_category_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
			}
			else
			{
					
				$_GVParamArray[] = array("KEY"=>"category_name", "VAL"=>$txtCategoryName, "TYPE"=>"s");
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update pdt_category_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and pdt_category_id=?";MYSQL_BuildArray("pdt_category_id",$GVID,"s");
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