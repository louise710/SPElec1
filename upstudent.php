<?php
include 'db.php';

$student = [];

if (isset($_GET['studid']) && is_numeric($_GET['studid'])) {
    $studid = intval($_GET['studid']);

    try {
        $sql = "SELECT * FROM students WHERE studid = :studid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':studid', $studid, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            echo "Error: Student not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Error: Invalid or missing student ID.";
    exit;
}

try {
    $sql = "SELECT collid, collfullname FROM colleges";
    $stmt = $db->query($sql);
    $colleges = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $colleges = [];
}

$programs = [];
if (isset($student['studcollid'])) {
    try {
        $sql = "SELECT progid, progfullname FROM programs WHERE progcollid = :collid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':collid', $student['studcollid'], PDO::PARAM_INT);
        $stmt->execute();
        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $studfirstname = trim($_POST['studfirstname']);
    $studlastname = trim($_POST['studlastname']);
    $studmidname = trim($_POST['studmidname']);
    $studcollid = intval($_POST['studcollid']);
    $studprogid = intval($_POST['studprogid']);
    $studyear = intval($_POST['studyear']);

    if (empty($studfirstname) || empty($studlastname) || empty($studcollid) || empty($studprogid) || empty($studyear)) {
        echo "Error: All required fields must be filled.";
    } else {
        try {
            $sql = "UPDATE students SET studfirstname = :studfirstname, studlastname = :studlastname, studmidname = :studmidname, 
                    studcollid = :studcollid, studprogid = :studprogid, studyear = :studyear WHERE studid = :studid";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':studfirstname', $studfirstname, PDO::PARAM_STR);
            $stmt->bindParam(':studlastname', $studlastname, PDO::PARAM_STR);
            $stmt->bindParam(':studmidname', $studmidname, PDO::PARAM_STR);
            $stmt->bindParam(':studcollid', $studcollid, PDO::PARAM_INT);
            $stmt->bindParam(':studprogid', $studprogid, PDO::PARAM_INT);
            $stmt->bindParam(':studyear', $studyear, PDO::PARAM_INT);
            $stmt->bindParam(':studid', $studid, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: student.php"); 
                exit;
            } else {
                echo "Error: Could not update the student.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    $db = null; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Student</title>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  
</head>

<body>
    <h2 style="text-align: center;">Update Student</h2>
    <form action="upstudent.php?studid=<?php echo htmlspecialchars($studid); ?>" method="post">
        <table class="table table-bordered mt-3">
            <tr>
                <td><label for="studid">Student ID:</label></td>
                <td><input type="number" name="studid" id="studid" class="form-control" value="<?php echo htmlspecialchars($student['studid']); ?>" readonly></td>
            </tr>
            <tr>
                <td><label for="studfirstname">First Name:</label></td>
                <td><input type="text" name="studfirstname" id="studfirstname" class="form-control" value="<?php echo htmlspecialchars($student['studfirstname']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="studlastname">Last Name:</label></td>
                <td><input type="text" name="studlastname" id="studlastname" class="form-control" value="<?php echo htmlspecialchars($student['studlastname']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="studmidname">Middle Name:</label></td>
                <td><input type="text" name="studmidname" id="studmidname" class="form-control" value="<?php echo htmlspecialchars($student['studmidname']); ?>"></td>
            </tr>
            <tr>
                <td><label for="studcollid">College:</label></td>
                <td>
                    <select name="studcollid" id="studcollid" class="form-control" required onchange="fetchPrograms(this.value)">
                        <option value="">-- Select a College --</option>
                        <?php foreach ($colleges as $college): ?>
                            <option value="<?php echo htmlspecialchars($college['collid']); ?>" <?php echo $college['collid'] == $student['studcollid'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($college['collfullname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
    <td><label for="studprogid">Program:</label></td>
    <td>
        <select name="studprogid" id="studprogid" class="form-control" required>
            <option value="">-- Select a Program --</option>
            <?php foreach ($programs as $program): ?>
                <option value="<?php echo htmlspecialchars($program['progid']); ?>" <?php echo $program['progid'] == $student['studprogid'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($program['progfullname']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
</tr>

            <tr>
                <td><label for="studyear">Year:</label></td>
                <td><input type="number" name="studyear" id="studyear" class="form-control" value="<?php echo htmlspecialchars($student['studyear']); ?>" required></td>
            </tr>
        </table>
        <center><button type="submit" class="btn btn-primary">Update Student</button></center>
    </form>
</body>

</html>
