<?php
include 'db.php';

if (isset($_GET['collid']) && is_numeric($_GET['collid'])) {
    $collid = intval($_GET['collid']);

    try {
        $sql = "SELECT progid, progfullname FROM programs WHERE progcollid = :collid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);
        $stmt->execute();

        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($programs); 
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
