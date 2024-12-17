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
    $collid = $_POST['collid'];
    $collfullname = $_POST['collfullname'];
    $collshortname = $_POST['collshortname'];

    try {
        $sql = "INSERT INTO colleges (collid, collfullname, collshortname) 
                VALUES (:collid, :collfullname, :collshortname)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':collid', $collid, PDO::PARAM_INT);
        $stmt->bindParam(':collfullname', $collfullname, PDO::PARAM_STR);
        $stmt->bindParam(':collshortname', $collshortname, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: coll.php");
        } else {
            echo "Error: Could not add the college.";
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
    <title>Add College</title>
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
    <h2>Add College</h2>
    <form action="addColl.php" method="post">
        <table class="table table-bordered mt-3">
            <tr>
                <td><label for="collid">College ID:</label></td>
                <td><input type="number" name="collid" id="collid" class="form-control" required></td>
            </tr>

            <tr>
                <td><label for="collfullname">Full Name:</label></td>
                <td><input type="text" name="collfullname" id="collfullname" class="form-control" required></td>
            </tr>

            <tr>
                <td><label for="collshortname">Short Name:</label></td>
                <td><input type="text" name="collshortname" id="collshortname" class="form-control" required></td>
            </tr>

            <!-- Optionally, you can display existing colleges if needed -->
            <!-- <tr>
                <td><label for="existingcollege">Existing College (optional):</label></td>
                <td>
                    <select name="existingcollege" id="existingcollege" class="form-control">
                        <option value="">Select a College</option>
                        <?php foreach ($colleges as $college): ?>
                            <option value="<?php echo htmlspecialchars($college['collid']); ?>">
                                <?php echo htmlspecialchars($college['collfullname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr> -->
        </table>
        <center><input type="submit" name="add" value="Add College" class="btn btn-primary"></center>
    </form>
</body>

</html>
