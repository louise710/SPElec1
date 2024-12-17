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
        $sql = "DELETE FROM departments WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Department deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Could not delete the department.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;  
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Department ID not provided or invalid.']);
}
?>
