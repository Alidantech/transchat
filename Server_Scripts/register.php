
 <?php 
 //this fuction validates the values
 function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

#insert the data and catch the exception
try {
  addNewUser();
  //displayUsersList();
} catch (mysqli_sql_exception $e) {
  //errorcode '1062' is used to catch duplicate values in this case phone number
  if($e->getCode() == 1062) {
    echo "Error: Duplicate value found for unique column.";
  } else {
    echo "Error another error occured: " . $e->getMessage();
  }
}
 
 #function for all the time a user registers
function addNewUser(){
  #getting the values that the user entered validating them and testing them for safety.
    $name = $phone = $password = "";
    $name = test_input($_POST["user_name"]);
    $phone = test_input($_POST["phone_no"]);
    $password = test_input($_POST["password"]);
    $timestamp = date('Y-m-d H:i:s');
  # CONNECTING TO THE DATABASE
    #Check connection
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "wechat_db";
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } else{
    echo"connected successifully";
  }
    #insert the user's data to the database
    $sql = "INSERT INTO users_data (user_name, phone_number, password, registration_date) 
            VALUES ('$name', '$phone', '$password_hash', '$timestamp')";
  if($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
  } else {
    echo "Error: You cannot register at the moment, try again. <br>
    If the problem persists contact your admin<br> " .$sql . "<br>" . $conn->error;
  }
  $conn->close();
}
//retrieve data from the database
#function for the db admin to see the users list
 //function displayUsersList(){
  // CONNECTING TO THE DATABASE
  #Check connection
//   $servername = "localhost";
//   $dbusername = "root";
//   $dbpassword = "";
//   $dbname = "wechat_db";
//   $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

//   $sql = ("SELECT * fROM users_data;");
//   $result = mysqli_query($conn, $sql);
//   // Check for errors
//   if(!$result) {
//     die("Error retrieving the data!!: " . $sql . "<br>" . mysqli_error($conn));
//   }
//   // Output the table data
//   if(mysqli_num_rows($result) > 0) {
//     //creating and styling a table to display the data
//     echo "<style>
//             table {
//               border-collapse: collapse;
//               width: 100%;
//               margin: 20px 0;
//               font-size: 18px;
//               color: #333;
//             }
            
//             th, td {
//               text-align: left;
//               padding: 8px;
//             }
            
//             th {
//               background-color: #f2f2f2;
//               color: #555;
//               font-weight: bold;
//             }
            
//             td {
//               border-bottom: 1px solid #ddd;
//             }
            
//             tbody tr:nth-child(even) {
//               background-color: #f2f2f2;
//             }
            
//           </style>
//           <table>";
//     while($row = mysqli_fetch_assoc($result)) {
//           echo "<tr><td>" .  $row["id"].
//                     "</td><td>" . $row["user_name"].
//                     "</td><td>" . $row["phone_number"]. 
//                     "</td><td>" . $row["password"]. 
//                     "</td><td>" . $row["registration_date"].
//                "</td></tr>";
//     }
//     echo "</table>";
//   } else {
//     echo "0 results";
//   }
// // clearing the table
// // $sql = "TRUNCATE TABLE users_data; ALTER TABLE users_data AUTO_INCREMENT = 1;";
// // if ($conn->multi_query($sql) === TRUE) {
// //     echo "Table cleared successfully";
// // }  else {
// //     echo "Error clearing table: " . $conn->error;
// // }
// $conn->close();
// }

?>
