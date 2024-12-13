<?php
include 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['college_id'])) {
    echo json_encode(['error' => 'College ID is required']);
    exit;
}

$collegeId = intval($_GET['college_id']);

try {
    $sql = "SELECT progid, progfullname FROM programs WHERE progcollid = :college_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':college_id', $collegeId, PDO::PARAM_INT);
    $stmt->execute();
    $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($programs);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}