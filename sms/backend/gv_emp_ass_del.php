<?
include("gv_header.php");
GVmasterAuth();

if ($GVSTEP == "DELETE") {
    $MySelectQry = "SELECT a.associate_id, e.gv_username, d.department_name 
                    FROM associate_info a
                    LEFT JOIN gv_login e ON a.employee_id = e.gv_login_id 
                    LEFT JOIN department_info d ON a.department_id = d.department_id
                    WHERE a.company_id=? AND a.associate_id=? AND a.delete_ind=0";
    MYSQL_BuildArray("company_id", $company_id, "s");
    MYSQL_BuildArray("associate_id", $GVID, "s");
    $MyDbResult = MyDbQuery($MySelectQry, $_GVParamArray);

    if ($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) {
        $empName = GVStringFormat($MyRowData['gv_username']);
        $deptName = GVStringFormat($MyRowData['department_name']);

        // Soft delete instead of hard delete
        $MyDeleteQry = "UPDATE associate_info SET delete_ind=1 WHERE company_id=? AND associate_id=?";
        MYSQL_BuildArray("company_id", $company_id, "s");
        MYSQL_BuildArray("associate_id", $GVID, "s");
        MyDbQuery($MyDeleteQry, $_GVParamArray);

        $gv_action = "$empName ($deptName) - Employee Mapping Deleted";
        include("gv_action_history.php");
    }
    MyDbFreeResult($MyDbResult);
}

GVPopSaveLoad();
include("gv_footer.php");
?>
