<?php
include 'db.php';

if (isset($_GET['college_id']) && isset($_GET['department_id'])) {
    $collegeId = $_GET['college_id'];
    $departmentId = $_GET['department_id'];

    try {
        $stmt = $db->prepare("
            SELECT progid, progfullname 
            FROM programs 
            WHERE progcollid = :college_id AND progcolldeptid = :department_id
        ");
        $stmt->bindParam(':college_id', $collegeId, PDO::PARAM_INT);
        $stmt->bindParam(':department_id', $departmentId, PDO::PARAM_INT);
        $stmt->execute();

        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($programs);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Missing parameters"]);
}
?>
