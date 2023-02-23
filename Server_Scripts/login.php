<?php  
#function to log in a user who is already registered.
function login($phone_number, $password) {
    $conn = new mysqli("localhost", "root", "", "wechat_db");
    if ($conn->connect_error) {
        die("cannot login, please try again:  -" . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT password FROM users_data WHERE phone_number = ?");
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($password_hash);
        $stmt->fetch();
        if (password_verify($password, $password_hash)) {
            session_start();
            $_SESSION["phone_number"] = $phone_number;
            $_SESSION["logged_in"] = true;
            header("Location: /Layouts/chatpage.html");
            exit();
        }  else {
            echo "You have entered an incorrect password.";
        }
    }   else {
        echo "The phone number you entered is not registerd.";
    }
    $stmt->close();
    $conn->close();
}
  //calling the login function
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = test_input($_POST["phone_no"]);
    $password = test_input($_POST["password"]);
    if( $phone_number==""){
        echo"you did not enter a phone number";
    } else if($password==""){
        echo"you did not enter a password";
    }else{
        login($phone_number, $password);
      } 
  } 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>