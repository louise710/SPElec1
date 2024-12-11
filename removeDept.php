<?php
// Include the database connection
include 'db.php';

if (isset($_GET['deptid'])) {
    $deptid = $_GET['deptid'];

    try {
        // Prepare the SQL statement to delete the department
        $sql = "DELETE FROM departments WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);

        // Bind the deptid to the SQL statement
        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Department deleted successfully";
        } else {
            echo "Error: Could not delete the department.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $db = null;
} else {
    echo "Error: Department ID not provided.";
}
?>
