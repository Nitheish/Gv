<?
include("gv_header.php");
		GVmasterAuth();
$company_id = $_POST['company_id'];
$department_id = $_POST['department_id'];

$sql = "SELECT a.associate_id AS id, l.gv_username AS name
        FROM associate_info a
        JOIN gv_login l ON a.employee_id = l.gv_login_id
        WHERE a.company_id = ? AND a.delete_ind = 0
        ORDER BY l.gv_username";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $company_id, $department_id);
$stmt->execute();
$result = $stmt->get_result();

$mappedEmployees = [];
while($row = $result->fetch_assoc()) {
    $mappedEmployees[] = $row;
}

echo json_encode($mappedEmployees);
?>
