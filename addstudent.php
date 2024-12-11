<<<<<<< HEAD
<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['studfirstname'];
    $lastName = $_POST['studlastname'];
    $middleName = $_POST['studmidname'];
    $college = $_POST['studcollid'];
    $program = $_POST['studprogid'];
    $year = $_POST['studyear'];

    try {
        $sql = "INSERT INTO student (studfirstname, studlastname, studmidname, studcollid, studprogid, studyear)
                VALUES (:studfirstname, :studlastname, :studmidname, :studcollid, :studprogid, :studyear)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':studfirstname', $firstName);
        $stmt->bindParam(':studlastname', $lastName);
        $stmt->bindParam(':studmidname', $middleName);
        $stmt->bindParam(':studcollid', $college);
        $stmt->bindParam(':studprogid', $program);
        $stmt->bindParam(':studyear', $year);

        if ($stmt->execute()) {
            echo "Student added successfully!";
        } else {
            echo "Error adding student.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
</head>

<body>
    <h2>Add Student</h2>
    <form action="addstudent.php" method="post">
        <table class="table table-bordered mt-3">
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
                <td><input type="text" name="studmidname" id="studmidname" class="form-control" required></td>
            </tr>
            
            <tr>
                <td><label>College: </label></td>
                <td>
                    <select name="college" id="college" class="form-control">
                        <option value="">-- Select College --</option>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Program: </label></td>
                <td>
                <!-- <td><input type="text" name="studprogid" id="studprogid" class="form-control" required></td> -->
                    <select name="program" id="program" class="form-control" onchange="updatePrograms()">
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
=======
<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['studfirstname'];
    $lastName = $_POST['studlastname'];
    $middleName = $_POST['studmidname'];
    $college = $_POST['studcollid'];
    $program = $_POST['studprogid'];
    $year = $_POST['studyear'];

    try {
        $sql = "INSERT INTO student (studfirstname, studlastname, studmidname, studcollid, studprogid, studyear)
                VALUES (:studfirstname, :studlastname, :studmidname, :studcollid, :studprogid, :studyear)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':studfirstname', $firstName);
        $stmt->bindParam(':studlastname', $lastName);
        $stmt->bindParam(':studmidname', $middleName);
        $stmt->bindParam(':studcollid', $college);
        $stmt->bindParam(':studprogid', $program);
        $stmt->bindParam(':studyear', $year);

        if ($stmt->execute()) {
            echo "Student added successfully!";
        } else {
            echo "Error adding student.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
</head>

<body>
    <h2>Add Student</h2>
    <form action="addstudent.php" method="post">
        <table class="table table-bordered mt-3">
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
                <td><input type="text" name="studmidname" id="studmidname" class="form-control" required></td>
            </tr>
            
            <tr>
                <td><label>College: </label></td>
                <td><input type="text" name="studcollid" id="studcollid" class="form-control" required></td>
            </tr>
            <tr>
                <td><label>Program: </label></td>
                <td><input type="text" name="studprogid" id="studprogid" class="form-control" required></td>
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
>>>>>>> 6b68f52ddbeb9ab58f368171fa249bb9cf0c1b84
