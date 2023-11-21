<?php
include_once("db.php");
include_once("student.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);


        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', 'rejaas070300');
        define('DB_NAME', 'school_db');


        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if(mysqli_connect_errno()){
        echo 'Failed to connect to MySQL '. mysqli_connect_errno();
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
    </script>
</head>

<body>
    <!-- Include the header -->
    <?php include('templates/header.html'); ?>
    <?php include('includes/navbar.php'); ?>


<div class="content">

    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search...">
        <button class="search-button">Search</button>
    </div>

    <div class="dashboard-title">Number of Students Enrolled</div>

    <div class="col-md-5">
        <div class="card ">
            <div class="content">
            <canvas id="student_gender" width="250" height="200"></canvas>
            <canvas id="townres" width="250" height="200"></canvas>
            </div>
        </div>
    </div>


    <?php 


        $query1 = "SELECT count(gender) as gender_count
        FROM students
        GROUP BY gender;";

        $result1 = mysqli_query($conn, $query1);
        if(mysqli_num_rows($result1) > 0){
            $order_count1 = array();
            //$label_barchart1 = array();
            while ($row = mysqli_fetch_array($result1)){
                $order_count1[] = $row['gender_count'];
                //$label_barchart1[] = $row['product_name'];
            }
            mysqli_free_result($result1);
        }else{
            echo "No records matching your query were found.";
        }

        // ----------------------------------------------------------

        $query2 = "SELECT town_city.name, count(student_details.town_city) as pertown
        FROM town_city, student_details
        WHERE town_city.id = student_details.town_city
        GROUP BY town_city.id
        ORDER BY pertown;";

        $result2 = mysqli_query($conn, $query2);
        if(mysqli_num_rows($result2) > 0){
            $order_count2 = array();
            $label_barchart2 = array();
            while ($row = mysqli_fetch_array($result2)){
                $order_count2[] = $row['pertown'];
                $label_barchart2[] = $row['name'];
            }
            mysqli_free_result($result2);
        }else{
            echo "No records matching your query were found.";
        }

        // ----------------------------------------------------------

    ?>

    <script>
        const order_count1 = <?php echo json_encode($order_count1); ?>;

        const data1 ={

        labels: ["Male", "Female"],
            datasets: [{
                label: 'Gender',
                data: order_count1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
        }]
        };
        // <!-- config block -->
        const config1 = {
            type: 'pie',
            data: data1,
            options: {
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        // <!-- render block -->
        const student_gender = new Chart(
            document.getElementById('student_gender'),
            config1
        );


        const label_barchart2 = <?php echo json_encode($label_barchart2); ?>;
        const order_count2 = <?php echo json_encode($order_count2); ?>;

        const data2 ={

        labels: label_barchart2,
            datasets: [{
                label: 'Town Residence',
                data: order_count2,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
        }]
        };
        // <!-- config block -->
        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        // <!-- render block -->
        const townres = new Chart(
            document.getElementById('townres'),
            config2
        );


       


    </script>
</div>

        <!-- Include the footer -->
    <?php include('templates/footer.html'); ?>
</body>
</html>
