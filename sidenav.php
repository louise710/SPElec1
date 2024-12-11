
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidenav</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="student.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Students
                </a>
                <a class="nav-link" href="dept.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-building"></i></div>
                    Departments
                </a>
                <a class="nav-link" href="college.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    Colleges
                </a>
                <a class="nav-link" href="prog.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                    Programs
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION["username"]; ?>
        </div>
    </nav>
</div>
</body>
</html>
