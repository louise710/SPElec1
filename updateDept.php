<?php
// Include the database connection
include 'db.php';

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

        if ($department) {
            // Display the form with current department details
            echo "<form action='updateDept.php' method='POST'>
                    <input type='hidden' name='deptid' value='" . $department['deptid'] . "' />
                    <div>
                        <label for='deptfullname'>Full Name</label>
                        <input type='text' name='deptfullname' value='" . htmlspecialchars($department['deptfullname']) . "' required />
                    </div>
                    <div>
                        <label for='deptshortname'>Short Name</label>
                        <input type='text' name='deptshortname' value='" . htmlspecialchars($department['deptshortname']) . "' required />
                    </div>
                    <div>
                        <label for='deptcollid'>College ID</label>
                        <input type='text' name='deptcollid' value='" . htmlspecialchars($department['deptcollid']) . "' required />
                    </div>
                    <button type='submit'>Update Department</button>
                </form>";
        } else {
            echo "Error: Department not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $db = null;
} else {
    echo "Error: Department ID not provided.";
}
?>
