 <?php
session_start();

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
    <script src="axios.min.js" crossorigin="anonymous"></script>
    <script src="axios.min.js.map" crossorigin="anonymous"></script>
    <style>
            body{
                background-image: url("assets/img.png");
            }
            #addModal .modal-content {
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            height: auto;
            }

            #editModal .modal-content {
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 40%;
                height: auto;
            }

            .close {
                color: #aaa;
                font-size: 28px;
                font-weight: bold;
                display: block;
                margin-left: auto;

            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
            table{
                border-collapse: collapse;
                width: 100%;
                font-family: var(--bs-font-sans-serif);
                margin-bottom: 5%;
            }
            th{
                background-color: white;
                color: black;
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;

            }
            tr td{
                padding: 6px;
                border: 1px solid #ddd;
            }
            tr{
                text-align: left;
                text-align: center;
            }
            tr:nth-child(even){
                background-color: #f2f2f2;
            }
            tr:hover{
                background-color: #ddd;
            }
            #addM:hover{
                background-color: #04AA6D;
                color: white;
            }
            .active-button {

            background-color: #04AA6D;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 4px;
        }

        .inactive-button {
            background-color: #DC3545;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 4px;
        }
       
        </style>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>
<body class="sb-nav-fixed">
    <?php include 'header.php';?>
<div id="layoutSidenav">
    <?php include 'sidenav.php';?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                    <h1 class="mt-4">STUDENT MANAGEMENT</h1>
                <h1 class="mt-4"></h1>
                <div class="card mb-4"> 
                    <div class="card-header">
                        <i class="fas fa-table me-1" style="padding: .5%"></i>
                        <button class="btn btn-success btn-sm" id= "addM" onclick="addModal()" style="position: absolute; right: 2%;">Add Student</button>
                    </div>
                    <div class="card-body">
                        <?php
    include 'db.php'; 

    try {
        $sql = "SELECT * FROM students";
        $stmt = $db->prepare($sql);

        $stmt->execute();

        echo "<table id='datatablesSimple' class='table'>
                <thead>  
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>College</th>
                        <th>Program Enrolled</th>
                        <th>Year</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["studid"]) . "</td>
                    <td>" . htmlspecialchars($row["studfirstname"]) . "</td>
                    <td>" . htmlspecialchars($row["studlastname"]) . "</td>
                    <td>" . htmlspecialchars($row["studmidname"]) . "</td>
                    <td>" . htmlspecialchars($row["studcollid"]) . "</td>
                    <td>" . htmlspecialchars($row["studprogid"]) . "</td>
                    <td>" . htmlspecialchars($row["studyear"]) . "</td>
                    <td>
                        <button class='btn btn-primary btn-sm' onclick=\"openModal({$row['studid']})\">Update</button>
                        <button class='btn btn-danger btn-sm' onclick=\"confirmDelete('{$row['studid']}')\">Delete</button>
                    </td>
                  </tr>";
        }

        echo "</tbody>
            </table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $db = null;
?>
                    </div>
                    <div id="addModal" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeAddModal()">&times;</span>

                                <?php include 'addstudent.php'; ?>
                            </div>
                        </div>
                    <div id="editModal" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <div id="upstudent"></div>
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
// change this into axios 
    function confirmDelete(studid) {
        var confirmDelete = confirm('Are you sure you want to delete?');
        if (confirmDelete) {
            axios.get('delstudent.php', { params: { studid: studid } })
                .then(response => {
                    window.location.href = 'delstudent.php?studid=' + studid;
                })
                .catch(error => {
                    console.error("Error deleting student:", error);
                });
        }
    }

    function openModal(studid) {
        axios.get('upstudent.php', { params: { studid: studid } })
            .then(response => {
                // Populate the modal with the response data
                document.getElementById("upstudent").innerHTML = response.data;
                document.getElementById("editModal").style.display = "block";
            })
            .catch(error => {
                console.error("Error fetching student data:", error);
            });
    }

    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }
    

</script>

</body>
</html>