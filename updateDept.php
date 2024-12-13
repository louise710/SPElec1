<?php
// Include the database connection
include 'db.php';

// Fetch the list of colleges to populate the dropdown
try {
    $sql = "SELECT collid, collfullname FROM colleges"; // Replace 'colleges' with your actual table name for colleges
    $stmt = $db->query($sql);
    $colleges = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $colleges = [];
}

// Fetch the existing department details if deptid is provided
$department = null;
if (isset($_GET['deptid'])) {
    $deptid = $_GET['deptid'];

    try {
        // Prepare the SQL query to fetch department details by deptid
        $sql = "SELECT * FROM departments WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the department data
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

// Check if the form is submitted to update the department
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deptid = $_POST['deptid'];
    $deptfullname = $_POST['deptfullname'];
    $deptshortname = $_POST['deptshortname'];
    $deptcollid = $_POST['deptcollid'];

    try {
        // Prepare the SQL statement to update the department
        $sql = "UPDATE departments 
                SET deptfullname = :deptfullname, deptshortname = :deptshortname, deptcollid = :deptcollid
                WHERE deptid = :deptid";
        $stmt = $db->prepare($sql);

        // Bind parameters to the SQL statement
        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmt->bindParam(':deptfullname', $deptfullname, PDO::PARAM_STR);
        $stmt->bindParam(':deptshortname', $deptshortname, PDO::PARAM_STR);
        $stmt->bindParam(':deptcollid', $deptcollid, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: dept.php"); // Redirect to department list page after success
            exit;
        } else {
            echo "Error: Could not update the department.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
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
