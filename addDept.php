<?php
// Include the database connection
include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deptid = $_POST['deptid'];
    $deptfullname = $_POST['deptfullname'];
    $deptshortname = $_POST['deptshortname'];
    $deptcollid = $_POST['deptcollid'];

    try {
        // Prepare the SQL statement to insert the new department
        $sql = "INSERT INTO departments (deptid, deptfullname, deptshortname, deptcollid) 
                VALUES (:deptid, :deptfullname, :deptshortname, :deptcollid)";
        $stmt = $db->prepare($sql);

        // Bind parameters to the SQL statement
        $stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
        $stmt->bindParam(':deptfullname', $deptfullname, PDO::PARAM_STR);
        $stmt->bindParam(':deptshortname', $deptshortname, PDO::PARAM_STR);
        $stmt->bindParam(':deptcollid', $deptcollid, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Department added successfully";
        } else {
            echo "Error: Could not add the department.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $db = null;
}
?>
<form action="addDept.php" method="POST">
<div>
        <label for="deptid">Department ID</label>
        <input type="int" name="deptid" required />
    </div>
    <div>
        <label for="deptfullname">Full Name</label>
        <input type="text" name="deptfullname" required />
    </div>
    <div>
        <label for="deptshortname">Short Name</label>
        <input type="text" name="deptshortname" required />
    </div>
    <div>
        <!-- dropdown -->
        <label for="deptcollid">College ID</label> 
        <input type="text" name="deptcollid" required />
    </div>
    <button type="submit">Add Department</button>
</form>
