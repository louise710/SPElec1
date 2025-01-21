<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; 

if (isset($_GET['collid']) && is_numeric($_GET['collid'])) {
    $collid = $_GET['collid'];

    try {
        // First, check if there are any departments linked to this college
        $sqlCheckDept = "SELECT COUNT(*) FROM departments WHERE deptcollid = :collid";
        $stmtCheckDept = $db->prepare($sqlCheckDept);
        $stmtCheckDept->bindParam(':collid', $collid, PDO::PARAM_INT);
        $stmtCheckDept->execute();
        $countDept = $stmtCheckDept->fetchColumn();

        // Check if there are any programs linked to this college or its departments
        $sqlCheckProg = "SELECT COUNT(*) FROM programs WHERE progcollid = :collid OR progcolldeptid IN (SELECT deptid FROM departments WHERE deptcollid = :collid)";
        $stmtCheckProg = $db->prepare($sqlCheckProg);
        $stmtCheckProg->bindParam(':collid', $collid, PDO::PARAM_INT);
        $stmtCheckProg->execute();
        $countProg = $stmtCheckProg->fetchColumn();

        if ($countDept > 0 || $countProg > 0) {
            // If there are dependent departments or programs, return an error message
            echo json_encode(['success' => false, 'message' => 'Cannot remove because the college has associated departments or programs.']);
        } else {
            // If no dependent records exist, proceed with the deletion of the college
            $sql = "DELETE FROM colleges WHERE collid = :collid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'College deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: Could not delete the college.']);
            }
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;
} else {
    echo json_encode(['success' => false, 'message' => 'Error: College ID not provided or invalid.']);
}
?>
