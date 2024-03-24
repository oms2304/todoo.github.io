<?php
require_once(__DIR__ . "/config.php");

// Check if the form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract type name from the form
    $password = $_POST["password"];
    $email = $_POST["email"];

            // Extract type name from the form
            $password = $_POST["password"];
    
            // Define SQL query to check if the data already exists
            $check_sql = "SELECT * FROM types WHERE name = ?";
        
            // Prepare the SQL statement
            $check_stmt = $db->prepare($check_sql);
        
            // Bind parameters to the prepared statement
            $check_stmt->bindParam(1, $password);
        
            // Execute the prepared statement
            $check_stmt->execute();
        
            // Check if any rows are returned
            if ($check_stmt->rowCount() > 0) {
                
                header("Location: todolist.php");
                exit;

            }
            else {
                 // Define SQL query with placeholders
                 $sql = "INSERT INTO types (name, email) VALUES (?,?)";
                 try {
                    // Prepare the SQL statement
                    $stmt = $db->prepare($sql);
                    // Bind parameters to the prepared statement
                    $stmt->bindParam(1, $password);
                    $stmt->bindParam(2, $email);
                    // Execute the prepared statement
                    $stmt->execute();
                    
                    echo "<script>alert('Account Created Successfully. Please Login');</script>";
                    require_once(__DIR__."test2/login.php");
                    

                }   catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        }
    ?>
