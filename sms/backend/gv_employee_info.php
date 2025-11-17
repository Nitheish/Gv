<?
if($GVSaveBtn)
{
    include("gv_header.php");
    GVmasterAuth();

    $LoadHtmlPage = "gv_employee_info";
    $ErrorInd = 0;

    // Sanitize inputs
    $txtEmployeeName = GVfixedInputText($txtEmployeeName);
    $txtUsername     = GVfixedInputText($txtUsername);
    $txtPassword     = GVfixedInputText($txtPassword);
    $txtEmail        = GVfixedInputText($txtEmail);
    $txtPhone        = GVfixedInputText($txtPhone);
    $txtAddress1     = GVfixedInputText($txtAddress);
    $txtAddress2     = GVfixedInputText($txtAddress2);
    $txtCity         = GVfixedInputText($txtCity);
    $txtState        = GVfixedInputText($txtState);
    $txtPincode      = GVfixedInputText($txtPincode);
    $txtDOB          = GVfixedInputText($txtDateOfBirth);
    $txtJoiningDate  = GVfixedInputText($txtJoiningDate);

    // Validation
    if(strlen($txtEmployeeName) == 0) GVSetErrorCodes("txtEmployeeName","Please enter Employee Name");
    if(strlen($txtUsername) == 0) GVSetErrorCodes("txtUsername","Please enter Username");
    if($GVSTEP=="ADD"){
     if(strlen($txtPassword) == 0) GVSetErrorCodes("txtPassword","Please enter Password");
    }

    // Check duplicate username
    $MySelectQry = "SELECT gv_login_id FROM gv_login WHERE company_id=?";
    MYSQL_BuildArray("company_id",$company_id,"s");
    if($GVSTEP=="EDIT"){
        $MySelectQry .= " AND gv_login_id!=?";
        MYSQL_BuildArray("gv_login_id",$GVID,"s");
    }
    $MySelectQry .= " AND gv_username=?";
    MYSQL_BuildArray("gv_username",$txtUsername,"s");

    $MyDbResult = MyDbQuery($MySelectQry,$_GVParamArray);
    $MyNumRows  = MyDbNumRows($MyDbResult);
    MyDbFreeResult($MyDbResult);
    if($MyNumRows>0) GVSetErrorCodes("txtUsername","Username already exists");

    if($ErrorInd==0){
        // Encrypt password
        $encryptedPassword = GVgenerateStringKEY($txtUsername,$txtPassword);

        if($GVSTEP=="ADD"){
            // Insert employee
            $checkGVkey = $gvky;
            $checkGVkey = GVStringFormat(GVstringDecrption($checkGVkey));
            $gv_account_key = GVStringFormat(substr($checkGVkey,40));
            $_GVParamArray[] = array("KEY"=>"gv_account_key","VAL"=>$gv_account_key,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"company_id","VAL"=>$company_id,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"gv_username","VAL"=>$txtUsername,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"gv_password","VAL"=>$encryptedPassword,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"login_type","VAL"=>"Employee","TYPE"=>"s"); // always Employee
            $_GVParamArray[] = array("KEY"=>"emp_name","VAL"=>$txtEmployeeName,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_addr1","VAL"=>$txtAddress1,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_addr2","VAL"=>$txtAddress2,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_city","VAL"=>$txtCity,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_state","VAL"=>$txtState,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_zip","VAL"=>$txtPincode,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_phone","VAL"=>$txtPhone,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_email","VAL"=>$txtEmail,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"date_of_birth","VAL"=>$txtDOB,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"date_of_join","VAL"=>$txtJoiningDate,"TYPE"=>"s");

            $outParamArr = GVgetQueryString($_GVParamArray);
            $MyInsertQry = "INSERT INTO gv_login (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") VALUES (".$outParamArr['_INSERT_SQLQRY_VAL'].")";
            MyDbQuery($MyInsertQry,$_GVParamArray);

            // Get last inserted ID
            $MySelectQry = "SELECT MAX(gv_login_id) AS MaxId FROM gv_login WHERE company_id=?";
            MYSQL_BuildArray("company_id",$company_id,"s");
            $MyDbResult = MyDbQuery($MySelectQry,$_GVParamArray);
            if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)){
                $GVID = GVStringFormat($MyRowData['MaxId']);
            }
            MyDbFreeResult($MyDbResult);

            $GVSTEP="EDIT";

        } else {
            // EDIT existing
            $_GVParamArray[] = array("KEY"=>"gv_username","VAL"=>$txtUsername,"TYPE"=>"s");
           
            $_GVParamArray[] = array("KEY"=>"emp_name","VAL"=>$txtEmployeeName,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_addr1","VAL"=>$txtAddress1,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_addr2","VAL"=>$txtAddress2,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_city","VAL"=>$txtCity,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_state","VAL"=>$txtState,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_zip","VAL"=>$txtPincode,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_phone","VAL"=>$txtPhone,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"emp_email","VAL"=>$txtEmail,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"date_of_birth","VAL"=>$txtDOB,"TYPE"=>"s");
            $_GVParamArray[] = array("KEY"=>"date_of_join","VAL"=>$txtJoiningDate,"TYPE"=>"s");

            $outParamArr = GVgetQueryString($_GVParamArray);
            $MyUpdateQry = "UPDATE gv_login SET ".$outParamArr['_UPDATE_SQLQRY_VAL']." WHERE company_id=? AND gv_login_id=?";
            MYSQL_BuildArray("company_id",$company_id,"s");
            MYSQL_BuildArray("gv_login_id",$GVID,"s");
            MyDbQuery($MyUpdateQry,$_GVParamArray);
        }

        GVPopSaveLoad();
    } else {
        include("../html/".$LoadHtmlPage.".html");
    }

    include("gv_footer.php");
}
?>
