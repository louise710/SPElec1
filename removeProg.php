<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  

if (isset($_GET['progid']) && is_numeric($_GET['progid'])) {
    $progid = $_GET['progid'];

    try {
        $sql = "DELETE FROM programs WHERE progid = :progid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':progid', $progid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Program deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Could not delete the program']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;  
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Program ID not provided or invalid.']);
}
?>
=======
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  

if (isset($_GET['progid']) && is_numeric($_GET['progid'])) {
    $progid = $_GET['progid'];

    try {
        $sql = "DELETE FROM programs WHERE progid = :progid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':progid', $progid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Program deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Could not delete the program']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;  
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Program ID not provided or invalid.']);
}
?>
>>>>>>> adcc3e978f5f335ba0921670c79b5a7a39a98060
