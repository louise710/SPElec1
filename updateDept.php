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

$department = null;
if (isset($_GET['deptid'])) {
    $deptid = $_GET['deptid'];

    try {
        $sql = "SELECT * FROM departments WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmt->execute();

        $department = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$department) {
            echo "Error: Department not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deptid = $_POST['deptid'];
    $deptfullname = $_POST['deptfullname'];
    $deptshortname = $_POST['deptshortname'];
    $deptcollid = $_POST['deptcollid'];

    try {
        $sql = "UPDATE departments 
                SET deptfullname = :deptfullname, deptshortname = :deptshortname, deptcollid = :deptcollid
                WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmt->bindParam(':deptfullname', $deptfullname, PDO::PARAM_STR);
        $stmt->bindParam(':deptshortname', $deptshortname, PDO::PARAM_STR);
        $stmt->bindParam(':deptcollid', $deptcollid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: dept.php"); 
            exit;
        } else {
            echo "Error: Could not update the department.";
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
    <title>Update Department</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h2>Update Department</h2>
    
    <?php if ($department): ?>
        <form action="updateDept.php?deptid=<?php echo $department['deptid']; ?>" method="post">
            <table class="table table-bordered mt-3">
                <tr>
                    <td><label for="deptid">Department ID:</label></td>
                    <td><input type="number" name="deptid" id="deptid" class="form-control" value="<?php echo htmlspecialchars($department['deptid']); ?>" readonly /></td>
                </tr>

                <tr>
                    <td><label for="deptfullname">Full Name:</label></td>
                    <td><input type="text" name="deptfullname" id="deptfullname" class="form-control" value="<?php echo htmlspecialchars($department['deptfullname']); ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="deptshortname">Short Name:</label></td>
                    <td><input type="text" name="deptshortname" id="deptshortname" class="form-control" value="<?php echo htmlspecialchars($department['deptshortname']); ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="deptcollid">College:</label></td>
                    <td>
                        <select name="deptcollid" id="deptcollid" class="form-control" required>
                            <option value="">Select a College</option>
                            <?php foreach ($colleges as $college): ?>
                                <option value="<?php echo htmlspecialchars($college['collid']); ?>"
                                        <?php echo ($college['collid'] == $department['deptcollid']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($college['collfullname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <center><input type="submit" name="update" value="Update Department" class="btn btn-primary"></center>
        </form>
    <?php endif; ?>
</body>

</html>
