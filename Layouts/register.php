

 <?php 
//  getting the user inputs.
//    $name = $_POST['user_name'];
//    $phone = $_POST['phone_no'];
//    $password = $_POST['password'];

// conecting to the database.
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "wechat_db";

   // define variables and set to empty values
        $nameErr = $phoneErr = $passwordErr = "";
        $name = $phone = $password = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["user_name"])) {
              $nameErr = "User Name is required";
            } else {
              $name = test_input($_POST["user_name"]);
            }
          
            if (empty($_POST["phone_no"])) {
              $phoneErr = "Phone number is required";
            } else {
              $email = test_input($_POST["phone_no"]);
            }
          
            if (empty($_POST["password"])) {
              $passwordErr = "please enter your password";
            } else {
              $website = test_input($_POST["password"]);
            }
        }
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         $name = test_input($_POST["user_name"]);
//         $phone = test_input($_POST["phone_no"]);
//         $password = test_input($_POST["password"]);
//       }
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo"connected successifully";
}
     $sql = "INSERT INTO users_data (user_name, phone_number, password) VALUES ('$name', '$phone', '$password')";
     if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
     $conn->close();
  ?>
