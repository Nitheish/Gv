<?
if ($GVSaveBtn)
{
    include("gv_header.php");
    GVmasterAuth();
    include("../info/gv_employee_info.php");

    $LoadHtmlPage = "gv_employee_info";
    $ErrorInd = 0;

    $txtEmployeeName = GVfixedInputText($txtEmployeeName);
    $txtUsername     = GVfixedInputText($txtUsername);
    $txtPassword     = GVfixedInputText($txtPassword);
    $txtEmail        = GVfixedInputText($txtEmail);
    $txtPhone        = GVfixedInputText($txtPhone);
    $txtAddress1      = GVfixedInputText($txtAddress1);
    $txtAddress2      = GVfixedInputText($txtAddress2);
    $txtCity         = GVfixedInputText($txtCity);
    $txtState        = GVfixedInputText($txtState);
    $txtPincode      = GVfixedInputText($txtPincode);
    $txtDateOfBirth  = GVfixedInputText($txtDateOfBirth);
    $txtJoiningDate  = GVfixedInputText($txtJoiningDate);
    $txtConfirmPassword = GVfixedInputText($txtConfirmPassword);
   
    $editLogin = isset($_POST['editLoginChk']) ? 1 : 0;

    if ($GVSTEP == "ADD" || ($GVSTEP == "EDIT" && $editLogin == 1))
    {
        if ($txtUsername == "")
        {
            GVSetErrorCodes("txtUsername","Please enter Username");
            $ErrorInd = 1;
        }

        if ($txtPassword == "")
        {
            GVSetErrorCodes("txtPassword","Please enter Password");
            $ErrorInd = 1;
        }

        if ($txtConfirmPassword == "")
        {
            GVSetErrorCodes("txtConfirmPassword","Please confirm Password");
            $ErrorInd = 1;
        }

        if ($txtPassword != "" && $txtConfirmPassword != "" && $txtPassword != $txtConfirmPassword)
        {
            GVSetErrorCodes("txtConfirmPassword","Password and Confirm Password must be same");
            $ErrorInd = 1;
        }
    }

    
    if ($ErrorInd == 1)
    {
        include("../html/".$LoadHtmlPage.".html");
        include("gv_footer.php");
        exit;
    }

    
    $dob = GVGetDateDBformat($txtDateOfBirth);
    $doj = GVGetDateDBformat($txtJoiningDate);

    
    if ($GVSTEP == "ADD")
    {
        $encPwd = GVgenerateStringKEY($txtUsername, $txtPassword);
        $checkGVkey = $gvky;
		$checkGVkey = GVStringFormat(GVstringDecrption($checkGVkey));
		
		$gv_session_key = GVStringFormat(substr($checkGVkey,0,40));
		$gv_account_key = GVStringFormat(substr($checkGVkey,40));

        $_GVParamArray = array();
        $_GVParamArray[] = array("KEY"=>"company_id","VAL"=>$company_id,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_username","VAL"=>$txtUsername,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_password","VAL"=>$encPwd,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"login_type","VAL"=>"Employee","TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_name","VAL"=>$txtEmployeeName,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_addr1","VAL"=>$txtAddress1,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_addr2","VAL"=>$txtAddress2,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_city","VAL"=>$txtCity,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_state","VAL"=>$txtState,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_zip","VAL"=>$txtPincode,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_phone","VAL"=>$txtPhone,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_email","VAL"=>$txtEmail,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"date_of_birth","VAL"=>$dob,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"date_of_join","VAL"=>$doj,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_session_key","VAL"=>$gv_session_key,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_account_key","VAL"=>$gv_account_key,"TYPE"=>"s");

        $outArr = GVgetQueryString($_GVParamArray);

        $MyInsertQry = "INSERT INTO gv_login (".$outArr['_INSERT_SQLQRY_FIELDS'].")
                        VALUES (".$outArr['_INSERT_SQLQRY_VAL'].")";
        MyDbQuery($MyInsertQry, $_GVParamArray);

        
        $_GVParamArray = array();
        $MySelectQry = "SELECT MAX(gv_login_id) AS MaxId FROM gv_login WHERE ";
        $MySelectQry .= "company_id=?"; MYSQL_BuildArray("company_id",$company_id,"s");

        $MyDbResult = MyDbQuery($MySelectQry,$_GVParamArray);
        if ($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC))
        {
            $GVID = GVStringFormat($MyRowData['MaxId']);
        }
        MyDbFreeResult($MyDbResult);

       
        $department_ids = isset($_POST['department_id']) ? $_POST['department_id'] : array();

        foreach ($department_ids as $deptId)
        {
            if ($deptId == "") continue;

            $_GVParamArray = array();
            $_GVParamArray[] = array("KEY"=>"company_id","VAL"=>$company_id,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"department_id","VAL"=>$deptId,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"employee_id","VAL"=>$GVID,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"delete_ind","VAL"=>"0","TYPE"=>"s");

            $outArr = GVgetQueryString($_GVParamArray);

            $MyInsertQry = "INSERT INTO associate_info (".$outArr['_INSERT_SQLQRY_FIELDS'].")
                            VALUES (".$outArr['_INSERT_SQLQRY_VAL'].")";
            MyDbQuery($MyInsertQry, $_GVParamArray);
        }
    }

    
    if ($GVSTEP == "EDIT")
    {
        $_GVParamArray = array();
        $encPwd = GVgenerateStringKEY($txtUsername, $txtPassword);
        $checkGVkey = $gvky;
		$checkGVkey = GVStringFormat(GVstringDecrption($checkGVkey));
		$gv_session_key = GVStringFormat(substr($checkGVkey,0,40));
		$gv_account_key = GVStringFormat(substr($checkGVkey,40));
        $_GVParamArray[] = array("KEY"=>"emp_name","VAL"=>$txtEmployeeName,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_addr1","VAL"=>$txtAddress1,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_addr2","VAL"=>$txtAddress2,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_city","VAL"=>$txtCity,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_state","VAL"=>$txtState,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_zip","VAL"=>$txtPincode,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_phone","VAL"=>$txtPhone,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"emp_email","VAL"=>$txtEmail,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"date_of_birth","VAL"=>$dob,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"date_of_join","VAL"=>$doj,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_username","VAL"=>$txtUsername,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_password","VAL"=>$encPwd,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_session_key","VAL"=>$gv_session_key,"TYPE"=>"s");
        $_GVParamArray[] = array("KEY"=>"gv_account_key","VAL"=>$gv_account_key,"TYPE"=>"s");

        $outArr = GVgetQueryString($_GVParamArray);

        $MyUpdateQry = "UPDATE gv_login SET ".$outArr['_UPDATE_SQLQRY_VAL']." WHERE ";
        $MyUpdateQry .= "company_id=? ";
        MYSQL_BuildArray("company_id",$company_id,"s");

        $MyUpdateQry .= "AND gv_login_id=?";
        MYSQL_BuildArray("gv_login_id",$GVID,"s");

        MyDbQuery($MyUpdateQry, $_GVParamArray);

        $department_ids = isset($_POST['department_id']) ? $_POST['department_id'] : array();

        $_GVParamArray = array();

        $delQry = "DELETE FROM associate_info WHERE company_id=? AND employee_id=?";
        MYSQL_BuildArray("company_id",$company_id,"s");
        MYSQL_BuildArray("employee_id",$GVID,"s");

        if (!empty($department_ids))
        {
            $placeholders = implode(',', array_fill(0, count($department_ids), '?'));
            $delQry .= " AND department_id NOT IN ($placeholders)";

            foreach ($department_ids as $deptId)
            {
                MYSQL_BuildArray("department_id",$deptId,"s");
            }
        }

        MyDbQuery($delQry, $_GVParamArray);

        foreach ($department_ids as $deptId)
        {
            if ($deptId == "") continue;

            $_GVParamArray = array();

            $chkQry = "SELECT 1 FROM associate_info 
                    WHERE company_id=? 
                    AND employee_id=? 
                    AND department_id=?";

            MYSQL_BuildArray("company_id",$company_id,"s");
            MYSQL_BuildArray("employee_id",$GVID,"s");
            MYSQL_BuildArray("department_id",$deptId,"s");

            $res = MyDbQuery($chkQry, $_GVParamArray);

            if (mysqli_num_rows($res) == 0)
            {
                $_GVParamArray = array();
                $_GVParamArray[] = array("KEY"=>"company_id","VAL"=>$company_id,"TYPE"=>"s");
                $_GVParamArray[] = array("KEY"=>"department_id","VAL"=>$deptId,"TYPE"=>"s");
                $_GVParamArray[] = array("KEY"=>"employee_id","VAL"=>$GVID,"TYPE"=>"s");
                $_GVParamArray[] = array("KEY"=>"delete_ind","VAL"=>"0","TYPE"=>"s");

                $outArr = GVgetQueryString($_GVParamArray);

                $insQry = "INSERT INTO associate_info (".$outArr['_INSERT_SQLQRY_FIELDS'].")
                        VALUES (".$outArr['_INSERT_SQLQRY_VAL'].")";

                MyDbQuery($insQry, $_GVParamArray);
            }

            MyDbFreeResult($res);
        }
    }

    $LoadHtmlPage = "gv_employee_list";

    include("../html/".$LoadHtmlPage.".html");
    include("gv_footer.php");
}
?>
