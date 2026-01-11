<?	
    $AJAXcallInd = 1;
    include("gv_header.php");
    GVmasterAuth();

    if($GVSTEP == "EMPLOYEE")
    {
        $department_id = GVfixedInputText($_POST['department_id']);
        //$company_id    = GVfixedInputText($_POST['company_id']);

        echo "<option value=''>---Select Employee---</option>";

        if( $department_id != "")
        {
            $empQry  = "SELECT gv_login_id AS id, gv_username AS name FROM gv_login WHERE";
            $empQry .= " company_id=?"; MYSQL_BuildArray("company_id", $company_id, "s");
            $empQry .= " AND delete_ind=?"; MYSQL_BuildArray("delete_ind", '0', "s");
            $empQry .= " AND active_ind=?"; MYSQL_BuildArray("active_ind", '0', "s");
            $empQry .= " AND gv_login_id NOT IN (";
            $empQry .= " SELECT employee_id FROM associate_info WHERE";
            $empQry .= " company_id=?"; MYSQL_BuildArray("company_id", $company_id, "s");
            $empQry .= " AND department_id=?"; MYSQL_BuildArray("department_id", $department_id, "s");
            $empQry .= " AND delete_ind='0'";
            $empQry .= " )";
            $empQry .= " ORDER BY gv_username";

            $MyDbResult = MyDbQuery($empQry, $_GVParamArray);

            if(mysqli_num_rows($MyDbResult) > 0)
            {
                while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC))
                {
                    $id   = GVStringFormat($MyRowData['id']);
                    $name = GVStringFormat($MyRowData['name']);

                    echo "<div class='form-check'>
                            <input class='form-check-input' type='checkbox' name='employee_id[]' value='$id' id='emp_$id'>
                            <label class='form-check-label' for='emp_$id'>$name</label>
                          </div>";
                }
            }
            else
            {
                echo "<p>No employees available</p>";
            }

            MyDbFreeResult($MyDbResult);
        }
    }
?>
