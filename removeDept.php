<?php
include 'db.php';

if (isset($_GET['deptid'])) {
    $deptid = $_GET['deptid'];

    try {
        $sql = "DELETE FROM departments WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Department deleted successfully";
        } else {
            echo "Error: Could not delete the department.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    
    $db = null;
} else {
    echo "Error: Department ID not provided.";
}
?>
