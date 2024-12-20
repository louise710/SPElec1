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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deptid = $_POST['deptid'];
    $deptfullname = $_POST['deptfullname'];
    $deptshortname = $_POST['deptshortname'];
    $deptcollid = $_POST['deptcollid'];

    try {
        $sql = "INSERT INTO departments (deptid, deptfullname, deptshortname, deptcollid) 
                VALUES (:deptid, :deptfullname, :deptshortname, :deptcollid)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmt->bindParam(':deptfullname', $deptfullname, PDO::PARAM_STR);
        $stmt->bindParam(':deptshortname', $deptshortname, PDO::PARAM_STR);
        $stmt->bindParam(':deptcollid', $deptcollid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: dept.php");
        } else {
            echo "Error: Could not add the department.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo "WWWWWWWWWWWWWWWWWW";
    }

    $db = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Department</title>
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
    <h2>Add Department</h2>
    <form action="addDept.php" method="post">
        <table class="table table-bordered mt-3">
            <tr>
                <td><label for="deptid">Department ID:</label></td>
                <td><input type="number" name="deptid" id="deptid" class="form-control" required></td>
            </tr>

            <tr>
                <td><label for="deptfullname">Full Name:</label></td>
                <td><input type="text" name="deptfullname" id="deptfullname" class="form-control" required></td>
            </tr>
            <tr>
                <td><label for="deptshortname">Short Name:</label></td>
                <td><input type="text" name="deptshortname" id="deptshortname" class="form-control" required></td>
            </tr>
            <tr>
                <td><label for="deptcollid">College:</label></td>
                <td>
                    <select name="deptcollid" id="deptcollid" class="form-control" required>
                        <option value="">Select a College</option>
                        <?php foreach ($colleges as $college): ?>
                            <option value="<?php echo htmlspecialchars($college['collid']); ?>">
                                <?php echo htmlspecialchars($college['collfullname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <center><input type="submit" name="add" value="Add Department" class="btn btn-primary"></center>
    </form>
</body>

</html>