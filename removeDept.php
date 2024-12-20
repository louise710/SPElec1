<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  

if (isset($_GET['deptid']) && is_numeric($_GET['deptid'])) {
    $deptid = $_GET['deptid'];

    try {
        // First, check if there are any rows in the colleges table that depend on this department.
        $sqlCheck = "SELECT COUNT(*) FROM colleges WHERE collid = (SELECT deptcollid FROM departments WHERE deptid = :deptid)";
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            // If there are dependent rows, return an error message
            echo json_encode(['success' => false, 'message' => 'Cannot remove because the department is associated with a college.']);
        } else {
            // If no dependent rows exist, proceed with the deletion
            $sql = "DELETE FROM departments WHERE deptid = :deptid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Department deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: Could not delete the department.']);
            }
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;  
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Department ID not provided or invalid.']);
}
?>
