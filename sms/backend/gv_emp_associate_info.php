<?
include("gv_header.php");
	GVmasterAuth();

// Check if form is submitted
if($GVSaveBtn == "Associate Employees") {

    $company_id    = $_POST['company_id'] ?? $company_id; // from session or hidden input
    $department_id = $_POST['department_id'] ?? '';
    $employee_ids  = $_POST['employee_id'] ?? [];

    $ErrorInd = 0;

    // Basic validation
    if(empty($department_id)) {
        GVSetErrorCodes("department_id", "Please select a department");
        $ErrorInd = 1;
    }

    if(empty($employee_ids)) {
        GVSetErrorCodes("employee_id", "Please select at least one employee");
        $ErrorInd = 1;
    }

    if($ErrorInd == 0) {

        foreach($employee_ids as $employee_id) {
            // Check if already associated
            $checkQry = "SELECT associate_id FROM associate_info 
                         WHERE company_id=? AND department_id=? AND employee_id=? AND delete_ind=0";
            $_GVParamArray = [];
            MYSQL_BuildArray("company_id", $company_id, "s");
            MYSQL_BuildArray("department_id", $department_id, "s");
            MYSQL_BuildArray("employee_id", $employee_id, "s");
            $checkRes = MyDbQuery($checkQry, $_GVParamArray);

            if(MyDbNumRows($checkRes) == 0) {
                MyDbFreeResult($checkRes);

                // Insert association
                $_GVParamArray = [];
                $_GVParamArray[] = array("KEY"=>"company_id","VAL"=>$company_id,"TYPE"=>"s");
                $_GVParamArray[] = array("KEY"=>"department_id","VAL"=>$department_id,"TYPE"=>"s");
                $_GVParamArray[] = array("KEY"=>"employee_id","VAL"=>$employee_id,"TYPE"=>"s");

                $outParamArr = GVgetQueryString($_GVParamArray);

                $insertQry = "INSERT INTO associate_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") 
                              VALUES(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
                MyDbQuery($insertQry, $_GVParamArray);
            } else {
                MyDbFreeResult($checkRes);
            }
        }

        // Success message
       include("../html/gv_emp_associate_info.html");
    } else {
        // On error, go back to the form
        include("../html/gv_emp_associate_info.html");
    }
}
include("../gv_footer.php");
?>
