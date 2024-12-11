<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>USJR - Finals</title>
    <style>
        /* Add your existing CSS styles here */
    </style>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include 'header.php'; ?>
    <div id="layoutSidenav">
        <?php include 'sidenav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">DEPARTMENT MANAGEMENT</h1>
                    <h1 class="mt-4"></h1>
                    <div class="card mb-4"> 
                        <div class="card-header">
                            <i class="fas fa-table me-1" style="padding: .5%"></i>
                            <button class="btn btn-success btn-sm" id="addM" onclick="addModal()" style="position: absolute; right: 2%;">Add Department</button>
                        </div>
                        <div class="card-body">
                            <?php
                            include 'db.php';  // Include the database connection

                            try {
                                // Query to fetch department data
                                $sql = "SELECT * FROM departments";  
                                $stmt = $db->prepare($sql);  // Prepare the PDO statement

                                $stmt->execute();  // Execute the query

                                echo "<table id='datatablesSimple' class='table'>
                                        <thead>  
                                            <tr>
                                                <th>Department ID</th>
                                                <th>Full Name</th>
                                                <th>Short Name</th>
                                                <th>College ID</th>
                                                <th>Operations</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                                // Loop through the result set and display data
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row["deptid"] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row["deptfullname"] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row["deptshortname"] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row["deptcollid"] ?? '') . "</td>
                                            <td>
                                                <button class='btn btn-primary btn-sm' onclick=\"openModal({$row['deptid']})\">Update</button>
                                                <button class='btn btn-danger btn-sm' onclick=\"confirmDelete('{$row['deptid']}')\">Delete</button>
                                            </td>
                                        </tr>";
                                }

                                echo "</tbody>
                                    </table>";
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            // Close the database connection
                            $db = null; 
                            ?>
                        </div>
                        <div id="addModal" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeAddModal()">&times;</span>
                                <?php include 'addDept.php'; ?> <!-- Add your department form here -->
                            </div>
                        </div>
                        <div id="editModal" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <div id="updateDept"></div> <!-- This will display the department update form -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include 'footer.php'; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="js/datatables-simple-demo.js"></script>
<script>
    function addModal() {
        document.getElementById("addModal").style.display = "block";
    }

    function closeAddModal() {
        document.getElementById("addModal").style.display = "none";
    }

    function confirmDelete(deptid) {
        var confirmDelete = confirm('Are you sure you want to delete?');
        if (confirmDelete) {
            window.location.href = 'removeDept.php?deptid=' + deptid;
        }
    }

    function openModal(deptid) {
        // Use AJAX to fetch edit content
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("updateDept").innerHTML = this.responseText;
                document.getElementById("editModal").style.display = "block";
            }
        };
        xhttp.open("GET", "updateDept.php?deptid=" + deptid, true);
        xhttp.send();
    }

    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }
</script>

</body>
</html>