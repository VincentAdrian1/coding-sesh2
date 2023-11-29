<?php
include_once("../db.php");
include_once("../town_city.php");


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
    <title>Result</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
    </script>
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>



    <div class="content">
    <h2 style="text-align: right; font-size: 64px; margin: 0px 30px 30px;">Report</h2>
        <div class="figures">
            <div class="figure1">
            <h2 class="report1" id="report1">Report 1: Number of Male and Female Students</h2>
            <canvas id="student_gender" width="500px" height="450px"></canvas>
            <p style="text-align: center;">Figure 1</p>

            <div class="para">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, exercitationem voluptatibus nisi possimus ratione in ex adipisci rem a, necessitatibus est. Laborum sapiente ut similique molestias maxime vel delectus iure nam, at deleniti rerum aliquam harum itaque alias fuga optio voluptatum voluptate libero quod dolorum amet. Doloremque, at. Id, adipisci corporis. Aspernatur, adipisci! Consectetur voluptates placeat quos quisquam, delectus illo debitis maiores aperiam, eaque laudantium at rerum atque nisi quidem fugit qui expedita. Eius corporis deserunt optio cupiditate molestias, hic, voluptas sunt debitis nam rerum officia ea placeat fuga blanditiis culpa a, asperiores harum distinctio saepe? Voluptatem non sed a.</p>
            </div>
            </div>



            <div class="figure2">
            <h2 class="report2" id="report2">Report 2: Number of Students per Town</h2>
            <canvas id="townres" width="500px" height="450px"></canvas>
            <p style="text-align: center;">Figure 2</p>
            <div class="para">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, exercitationem voluptatibus nisi possimus ratione in ex adipisci rem a, necessitatibus est. Laborum sapiente ut similique molestias maxime vel delectus iure nam, at deleniti rerum aliquam harum itaque alias fuga optio voluptatum voluptate libero quod dolorum amet. Doloremque, at. Id, adipisci corporis. Aspernatur, adipisci! Consectetur voluptates placeat quos quisquam, delectus illo debitis maiores aperiam, eaque laudantium at rerum atque nisi quidem fugit qui expedita. Eius corporis deserunt optio cupiditate molestias, hic, voluptas sunt debitis nam rerum officia ea placeat fuga blanditiis culpa a, asperiores harum distinctio saepe? Voluptatem non sed a.</p>
            </div>
            
            </div>


            <div class="figure3">
            <h2 class="report3" id="report3">Report 3: Number of Students per Province</h2>
            <canvas id="provres" width="500px" height="450px"></canvas>
            <p style="text-align: center;">Figure 3</p>
            <div class="para">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, exercitationem voluptatibus nisi possimus ratione in ex adipisci rem a, necessitatibus est. Laborum sapiente ut similique molestias maxime vel delectus iure nam, at deleniti rerum aliquam harum itaque alias fuga optio voluptatum voluptate libero quod dolorum amet. Doloremque, at. Id, adipisci corporis. Aspernatur, adipisci! Consectetur voluptates placeat quos quisquam, delectus illo debitis maiores aperiam, eaque laudantium at rerum atque nisi quidem fugit qui expedita. Eius corporis deserunt optio cupiditate molestias, hic, voluptas sunt debitis nam rerum officia ea placeat fuga blanditiis culpa a, asperiores harum distinctio saepe? Voluptatem non sed a.</p>
            </div>
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


        $query3 = "SELECT province.name, count(student_details.province) as perprov
        FROM province, student_details
        WHERE province.id = student_details.province
        GROUP BY province.id
        ORDER BY perprov;";

        $result3 = mysqli_query($conn, $query3);
        if(mysqli_num_rows($result3) > 0){
            $order_count3 = array();
            $label_barchart3 = array();
            while ($row = mysqli_fetch_array($result3)){
                $order_count3[] = $row['perprov'];
                $label_barchart3[] = $row['name'];
            }
            mysqli_free_result($result3);
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



        const label_barchart3 = <?php echo json_encode($label_barchart3); ?>;
        const order_count3 = <?php echo json_encode($order_count3); ?>;

        const data3 ={

        labels: label_barchart3,
            datasets: [{
                label: 'Province Residence',
                data: order_count3,
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
        const config3 = {
            type: 'bar',
            data: data2,
            options: {
                indexAxis: "y",
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        // <!-- render block -->
        const provres = new Chart(
            document.getElementById('provres'),
            config3
        );


       


    </script>
        

    </div>
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>
