<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
echo $_SESSION['username']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pie Chart Demo (LibChart)- https://codeofaninja.com/</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>

<?php
    //include the library
    include "libchart/classes/libchart.php";
    header("Content-type: image/png");

    //new pie chart instance
    $chart = new PieChart( 500, 300 );

    //data set instance
    $dataSet = new XYDataSet();

    //actual data
    //get data from the database

    //include database connection
    $mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

    //query all records from the database
    $temp_id = $_SESSION['poll_id_stats'];
    $query = "SELECT total_votes FROM Options WHERE poll_id = '$temp_id'";

    //execute the query
    $result = $mysqli->query($query);

    //get number of rows returned
    $num_results = $result->num_rows;

    if( $num_results > 0){

        while( $row = $result->fetch_assoc() ){
            extract($row);
            $dataSet->addPoint(new Point("{$name} {$ratings})", $ratings));
        }

        //finalize dataset
        $chart->setDataSet($dataSet);

        //set chart title
        $chart->setTitle("Tiobe Top Programming Languages for June 2012");

        //render as an image and store under "generated" folder
        $chart->render("generated/1.png");

        //pull the generated chart where it was stored
        echo "<img alt='Pie chart'  src='generated/1.png' style='border: 1px solid gray;'/>";

    }else{
        echo "No programming languages found in the database.";
    }
?>

</body>
</html>
