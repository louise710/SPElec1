<?php
include 'db.php';  

try {
    $sql = "SELECT collid, collfullname FROM colleges"; 
    $stmt = $db->query($sql);
    $colleges = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT deptid, deptfullname FROM departments"; 
    $stmt = $db->query($sql);
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $colleges = [];
    $departments = [];
}

$program = null;
if (isset($_GET['progid'])) {
    $progid = $_GET['progid'];

    try {
        $sql = "SELECT * FROM programs WHERE progid = :progid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':progid', $progid, PDO::PARAM_INT);
        $stmt->execute();

        $program = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$program) {
            echo "Error: Program not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $progid = $_POST['progid'];
    $progfullname = $_POST['progfullname'];
    $progshortname = $_POST['progshortname'];
    $progcollid = $_POST['progcollid'];
    $progcolldeptid = $_POST['progcolldeptid'];

    try {
        $sql = "UPDATE programs 
                SET progfullname = :progfullname, progshortname = :progshortname, progcollid = :progcollid, progcolldeptid = :progcolldeptid
                WHERE progid = :progid";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':progid', $progid, PDO::PARAM_INT);
        $stmt->bindParam(':progfullname', $progfullname, PDO::PARAM_STR);
        $stmt->bindParam(':progshortname', $progshortname, PDO::PARAM_STR);
        $stmt->bindParam(':progcollid', $progcollid, PDO::PARAM_INT);
        $stmt->bindParam(':progcolldeptid', $progcolldeptid, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: prog.php");  
            exit;
        } else {
            echo "Error: Could not update the program.";
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
    <title>Update Program</title>
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
    <h2>Update Program</h2>

    <?php if ($program): ?>
        <form action="updateProg.php?progid=<?php echo $program['progid']; ?>" method="post">
            <table class="table table-bordered mt-3">
                <tr>
                    <td><label for="progid">Program ID:</label></td>
                    <td><input type="number" name="progid" id="progid" class="form-control" value="<?php echo htmlspecialchars($program['progid']); ?>" readonly /></td>
                </tr>

                <tr>
                    <td><label for="progfullname">Full Name:</label></td>
                    <td><input type="text" name="progfullname" id="progfullname" class="form-control" value="<?php echo htmlspecialchars($program['progfullname']); ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="progshortname">Short Name:</label></td>
                    <td><input type="text" name="progshortname" id="progshortname" class="form-control" value="<?php echo htmlspecialchars($program['progshortname']); ?>" required /></td>
                </tr>

                <tr>
                    <td><label for="progcollid">College:</label></td>
                    <td>
                        <select name="progcollid" id="progcollid" class="form-control" required>
                            <option value="">Select a College</option>
                            <?php foreach ($colleges as $college): ?>
                                <option value="<?php echo htmlspecialchars($college['collid']); ?>"
                                        <?php echo ($college['collid'] == $program['progcollid']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($college['collfullname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="progcolldeptid">Department:</label></td>
                    <td>
                        <select name="progcolldeptid" id="progcolldeptid" class="form-control" required>
                            <option value="">Select a Department</option>
                            <?php foreach ($departments as $department): ?>
                                <option value="<?php echo htmlspecialchars($department['deptid']); ?>"
                                        <?php echo ($department['deptid'] == $program['progcolldeptid']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($department['deptfullname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <center><input type="submit" name="update" value="Update Program" class="btn btn-primary"></center>
        </form>
    <?php endif; ?>
</body>

</html>
