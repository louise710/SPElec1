<<<<<<< HEAD
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
        $sql = "DELETE FROM colleges WHERE collid = :collid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Colleges deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Could not delete the colleges.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Colleges ID not provided or invalid.']);
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

if (isset($_GET['collid']) && is_numeric($_GET['collid'])) {
    $collid = $_GET['collid'];

    try {
        $sql = "DELETE FROM colleges WHERE collid = :collid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Colleges deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: Could not delete the colleges.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $db = null;
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Colleges ID not provided or invalid.']);
}
?>
>>>>>>> adcc3e978f5f335ba0921670c79b5a7a39a98060
