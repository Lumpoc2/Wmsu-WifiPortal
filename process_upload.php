<?php
try {
    // Database connection parameters
    $dsn = "mysql:host=195.35.61.69;dbname=u991923994_fal_db";
    $username = "u991923994_fal";
    $password = '$R3s~qkna+xj';

    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // CSV file path
    $csvFile = $_FILES['excelFile']['tmp_name'];

    // Open and read the CSV file
    $file = fopen($csvFile, 'r');
    if ($file === false) {
        throw new Exception("Error opening CSV file");
    }

    // Get column names from the header row
    $header = fgetcsv($file, 0, ',');

    // Prepare the INSERT query
    $columns = implode(',', $header);
    $values = implode(',', array_fill(0, count($header), '?'));

    $query = "INSERT INTO student_tbl ($columns) VALUES ($values)";
    $statement = $pdo->prepare($query);

    // Process each row in the CSV file
    while (($data = fgetcsv($file, 0, ',')) !== false) {
        // Bind parameters and execute the query
        foreach ($data as &$value) {
            $value = trim($value);
        }
        $statement->execute($data);
    }

    // Close the file
    fclose($file);

    echo "<script> alert('Data imported successfully.'); </script>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    $pdo = null;
    echo "<script> window.location='students/'; </script>";
}
?>