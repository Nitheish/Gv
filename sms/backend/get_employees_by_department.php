<?
// Include DB connection
$AJAXcallInd = 1;
include("gv_header.php");
GVmasterAuth();

if ($GVSTEP == "EMPLOYEE") {
    $department_id = $_POST['department_id'] ?? '';
    $company_id    = $_POST['company_id'] ?? '';

    // Default option
    echo "<option value=''>---Select Employee---</option>";

    if ($company_id && $department_id) {
        $empQry = "SELECT gv_login_id AS id, gv_username AS name
                   FROM gv_login
                   WHERE company_id = ?
                     AND delete_ind = 0
                     AND active_ind = 0
                     AND gv_login_id NOT IN (
                         SELECT employee_id
                         FROM associate_info
                         WHERE company_id = ? 
                         AND department_id = ?
                           AND delete_ind = 0
                     )
                   ORDER BY gv_username";

        $_GVParamArray = [];
        MYSQL_BuildArray("company_id", $company_id, "s");     // (1)
        
        MYSQL_BuildArray("company_id", $company_id, "s");     // (3)
        MYSQL_BuildArray("department_id", $department_id, "s"); // (3)

        $MyDbResult = MyDbQuery($empQry, $_GVParamArray);

         if (mysqli_num_rows($MyDbResult) > 0) {
            while ($row = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) {
                $id   = GVStringFormat($row['id']);
                $name = GVStringFormat($row['name']);
                echo "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='employee_id[]' value='$id' id='emp_$id'>
                        <label class='form-check-label' for='emp_$id'>$name</label>
                      </div>";
            }
        } else {
            echo "<p>No employees available</p>";
        }
        MyDbFreeResult($MyDbResult);
    }
}
?>
