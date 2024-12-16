<?php
include 'db.php';

if (isset($_GET['studid'])) {
    $studid = $_GET['studid'];

    try {
        $sql = "DELETE FROM students WHERE studid = :studid";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':studid', $studid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: student.php");
        } else {
            echo "Error: Could not delete the student.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $db = null;
} else {
    echo "Error: Student ID not provided.";
}
?>
