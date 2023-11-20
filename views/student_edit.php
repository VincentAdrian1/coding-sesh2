<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php");
include_once("../student_details.php"); // Include the Student class file
include_once("../town_city.php");
include_once("../province.php"); // Include the Student class file

// student edit part
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student data by ID from the database
    $db = new Database();
    $student = new Student($db);
    $studentData = $student->read($id); // Implement the read method in the Student class

    if ($studentData) {
        // The student data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "Student not found.";
    }
} else {
    echo "Student ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'student_number' => $_POST['student_number'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
    ];

    $db = new Database();
    $student = new Student($db);

    // Call the edit method to update the student data
    if ($student->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
    header("Location: students.view.php");
}
// student edit end

// Student details part
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student data by ID from the database
    $db = new Database();
    $studentdetails = new StudentDetails($db);
    $studentDet = $studentdetails->read($id); // Implement the read method in the Student class

    if ($studentDet) {
        // The student data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "Student detail not found.";
    }
} else {
    echo "Student ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'student_id' => $_POST['student_id'],
        'contact_number' => $_POST['contact_number'],
        'street' => $_POST['street'],
        'town_city' => $_POST['town_city'],
        'province' => $_POST['province'],
        'zipcode' => $_POST['zip_code'],
    ];

    $db = new Database();
    $studentdetails = new StudentDetails($db);

    // Call the edit method to update the student data
    if ($studentdetails->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
    header("Location: students.view.php");
}

// student details end here
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Student</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Student Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $studentData['id']; ?>">
        
        <label for="student_number">Student Number:</label>
        <input type="text" name="student_number" id="student_number" value="<?php echo $studentData['student_number']; ?>">
        
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $studentData['first_name']; ?>">
        
        <label for="middle_name">Middle Name:</label>
        <input type="text" name= "middle_name" id="middle_name" value="<?php echo $studentData['middle_name']; ?>">
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $studentData['last_name']; ?>">
        
        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
            <option value="0">Male</option>
            <option value="1">Female</option>
        </select>
        <!-- <input type="text" name="gender" id="gender" value="<?php echo $studentData['gender']; ?>"> -->
        
        <label for="birthday">Birthdate:</label>
        <input type="text" name="birthday" id="birthday" value="<?php echo $studentData['birthday']; ?>">

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" value="<?php echo $studentDet['contact_number']; ?>" required>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street"  value="<?php echo $studentDet['street']; ?>" required>

        <label for="town_city">Town / City:</label>
        <select name="town_city" id="town_city" required>
        <?php
            $database = new Database();
            $towns = new TownCity($database);
            $results = $towns->getAll();
            // echo print_r($results);
            foreach($results as $result)
            {
                echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
            }
        ?>      
        </select>

        <label for="province">Province:</label>
        <select name="province" id="province" required>
        <?php

            $database = new Database();
            $provinces = new Province($database);
            $results = $provinces->getAll();
            // echo print_r($results);
            foreach($results as $result)
            {
                echo '<option value="' . $result['id'] . '">' . $result['name'] . '</option>';
            }
        ?>  
        </select>    

        <label for="zip_code">Zip Code:</label>
        <input type="text" id="zip_code" name="zip_code" value="<?php echo $studentDet['zip_code']; ?>" required>
        

        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
