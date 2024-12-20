<?php
include 'db.php';  

try {
    $sql = "SELECT collid, collfullname FROM colleges"; 
    $stmt = $db->query($sql);
    $colleges = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $colleges = [];
}

$college = null;
if (isset($_GET['collid'])) {
    $collid = $_GET['collid'];

    try {
        $sql = "SELECT * FROM colleges WHERE collid = :collid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);
        $stmt->execute();

        $college = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$college) {
            echo "Error: College not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $collid = $_POST['collid'];
    $collfullname = $_POST['collfullname'];
    $collshortname = $_POST['collshortname'];

    try {
        $sql = "UPDATE colleges 
                SET collfullname = :collfullname, collshortname = :collshortname
                WHERE collid = :collid";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);
        $stmt->bindParam(':collfullname', $collfullname, PDO::PARAM_STR);
        $stmt->bindParam(':collshortname', $collshortname, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: coll.php");  
            exit;
        } else {
            echo "Error: Could not update the college.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $db = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update College</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h2>Update College</h2>

    <?php if ($college): ?>
        <form action="updateColl.php?collid=<?php echo $college['collid']; ?>" method="post">
            <table class="table table-bordered mt-3">
                <tr>
                    <td><label for="collid">College ID:</label></td>
                    <td><input type="number" name="collid" id="collid" class="form-control" value="<?php echo htmlspecialchars($college['collid']); ?>" readonly /></td>
                </tr>

                <tr>
                    <td><label for="collfullname">Full Name:</label></td>
                    <td><input type="text" name="collfullname" id="collfullname" class="form-control" value="<?php echo htmlspecialchars($college['collfullname']); ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="collshortname">Short Name:</label></td>
                    <td><input type="text" name="collshortname" id="collshortname" class="form-control" value="<?php echo htmlspecialchars($college['collshortname']); ?>" required /></td>
                </tr>
            </table>
            <center><input type="submit" name="update" value="Update College" class="btn btn-primary"></center>
        </form>
    <?php endif; ?>
</body>

</html>
