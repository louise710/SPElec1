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
    $studid = $_POST['studid'];
    $studfirstname = $_POST['studfirstname'];
    $studlastname = $_POST['studlastname'];
    $studmidname = $_POST['studmidname'];
    $studcollid = $_POST['studcollid'];
    $studprogid = $_POST['studprogid'];
    $studyear = $_POST['studyear'];

    try {
        $sql = "INSERT INTO students (studid, studfirstname, studlastname, studmidname, studcollid, studprogid, studyear) 
                VALUES (:studid, :studfirstname, :studlastname, :studmidname, :studcollid, :studprogid, :studyear)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':studid', $studid, PDO::PARAM_INT);
        $stmt->bindParam(':studfirstname', $studfirstname, PDO::PARAM_STR);
        $stmt->bindParam(':studlastname', $studlastname, PDO::PARAM_STR);
        $stmt->bindParam(':studmidname', $studmidname, PDO::PARAM_STR);
        $stmt->bindParam(':studcollid', $studcollid, PDO::PARAM_INT);
        $stmt->bindParam(':studprogid', $studprogid, PDO::PARAM_INT);
        $stmt->bindParam(':studyear', $studyear, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: student.php");
        } else {
            echo "Error: Could not add the student.";
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
    <title>Add Student</title>
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
    <script>
        function fetchPrograms(collegeId) {
            const programDropdown = document.getElementById('studprogid');

            programDropdown.innerHTML = '<option value="">-- Select Program --</option>';

            if (!collegeId) return; 

            axios.get(`get_programs.php?college_id=${collegeId}`)
                .then(response => {
                    const data = response.data;

                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    data.forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.progid;
                        option.textContent = program.progfullname;
                        programDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching programs:', error));
        }
    </script>
</head>

<body>
    <h2>Add Student</h2>
    <form action="addstudent.php" method="post">
        <table class="table table-bordered mt-3">
            <tr>
                <td><label>Student ID: </label></td>
                <td><input type="number" name="studid" id="studid" class="form-control" required></td>
            </tr>
            <tr>
                <td><label>First Name: </label></td>
                <td><input type="text" name="studfirstname" id="studfirstname" class="form-control" required></td>
            </tr>
            <tr>
                <td><label>Last Name: </label></td>
                <td><input type="text" name="studlastname" id="studlastname" class="form-control" required></td>
            </tr>
            <tr>
                <td><label>Middle Name: </label></td>
                <td><input type="text" name="studmidname" id="studmidname" class="form-control"></td>
            </tr>

            <tr>
                <td><label for="studcollid">College:</label></td>
                <td>
                    <select name="studcollid" id="studcollid" class="form-control" required onchange="fetchPrograms(this.value)">
                        <option value="">-- Select a College --</option>
                        <?php foreach ($colleges as $college): ?>
                            <option value="<?php echo htmlspecialchars($college['collid']); ?>">
                                <?php echo htmlspecialchars($college['collfullname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Program: </label></td>
                <td>
                    <select name="studprogid" id="studprogid" class="form-control" required>
                        <option value="">-- Select Program --</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Year: </label></td> 
                <td><input type="number" name="studyear" id="studyear" class="form-control"></td> 
            </tr>
        </table>
        <center><input type="submit" name="add" value="Add Student" class="btn btn-primary"></center>
    </form>
</body>

</html>
