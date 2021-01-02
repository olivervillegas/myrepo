<?php
namespace Phppot;

class Member
{
    const HOST = 'localhost';

    const USERNAME = 'root';

    const PASSWORD = 'root';

    const DATABASENAME = 'user_registration';

    $conn = new mysqli_connect('localhost', 'root', 'root', 'user_registration');

    private $ds;

    private $query;

    public function isEmailExists($email)
    {
        $query = 'SELECT email FROM tbl_member';


    }

    /**
     * to signup / register a user
     *
     * @return string[] registration status message
     */
    public function registerMember()
    {
        global $query;
        global $conn;

        $isEmailExists = $this->isEmailExists($_POST["email"]);
        if ($isEmailExists) {
            $response = array(
                "status" => "error",
                "message" => "Email already exists."
            );
        } else {
            if (! empty($_POST["signup-password"])) {

                // PHP's password_hash is the best choice to use to store passwords
                // do not attempt to do your own encryption, it is not safe
                //$hashedPassword = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);
            }
            //$query = "INSERT INTO tbl_member(firstname, lastname, role, email, password)
              //        VALUES ($_POST[firstname], $_POST[firstname], $_POST[firstname], $_POST[firstname], $_POST[firstname])";
            /*$paramType = 'sss';
            $paramValue = array(
                $_POST["firstname"],
                $_POST["lastname"],
                $_POST["role"],
                $hashedPassword,
                $_POST["email"]
            );
            $memberId = $this->ds->insert($query, $paramType, $paramValue);
            if (! empty($memberId)) {
                $response = array(
                    "status" => "success",
                    "message" => "You have registered successfully."
                );



            $conn = new \mysqli('localhost', 'root', 'root', 'user_registration');
            if ($conn->query($query) === TRUE) {
              echo "New record created successfully";
            } else {
              echo "Error: ";
            }*/

            ini_set('display_errors', 1); error_reporting(E_ALL);

            // 1. Create connection to database

            mysqli_connect('localhost', 'root', 'root', 'user_registration') or die('Could not connect to mysql: <hr>'.mysql_error());
            $connect = mysqli_connect('localhost', 'root', 'root', 'user_registration');
            // 2. Select database

            //mysql_select_db("user_registration") or die('Could not connect to database:<hr>'.mysql_error());


            // 3. Assign variables (after connection as required by escape string)

              $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
              $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
              $role = mysqli_real_escape_string($connect, $_POST['role']);
              $email = mysqli_real_escape_string($connect, $_POST['email']);
              $hashedPassword = password_hash($_POST['signup-password'], PASSWORD_DEFAULT);
              $password = mysqli_real_escape_string($connect, $hashedPassword);


            // 4. Insert data into table

            mysqli_query($connect, "INSERT INTO tbl_member (firstname, lastname, role, email, password) VALUES ('$firstname', '$lastname', '$role', '$email', '$password')");

            Echo 'Your information has been successfully added to the database.';

            print_r($_POST);

            //mysql_close();
        }
        return "Failed to create account";
    }

    public function getMember($email)
    {
        $mysqli = new \mysqli('localhost', 'root', 'root', 'user_registration');
        $result = $mysqli->query("SELECT password FROM tbl_member WHERE email = $email");
        echo $result;
        return $result;

        /*$query = 'SELECT email FROM tbl_member where email = ?';
        $paramType = 's';
        $paramValue = array(
            $email
        );
        $memberRecord = $this->ds->select($result, $paramType, $paramValue);
        return $memberRecord;*/
    }

    /**
     * to login a user
     *
     * @return string
     */
    public function loginMember()
    {
        $email = $_POST["email"];
        $password = $_POST["login-password"];

        $startconn = new \mysqli('localhost', 'root', 'root', 'user_registration');


        $result1 = mysqli_query($startconn, "SELECT email AS email FROM tbl_member WHERE email = '".$email."'");
        $emailrow = mysqli_fetch_array($result1);

        if(mysqli_num_rows($result1) > 0 )
        {
            $result2 = mysqli_query($startconn, "SELECT password AS password FROM tbl_member WHERE email = '".$email."'");
            $row = mysqli_fetch_array($result2);

            if (password_verify($password, $row['password']))
            {
                $loginPassword = 1;
            }
            else
            {
                $loginPassword = 0;
            }
        }
        else
        {
            $loginPassword = 0;
        }

        if ($loginPassword == 1) {
            // login sucess so store the member's username in
            // the session
            session_start();
            $_SESSION["email"] = $emailrow["email"];
            session_write_close();
            $url = "./home.php";
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Invalid username or password.";
            return $loginStatus;
        }
    }

    public function getMeetings()
    {

    }

    public function createMeetings()
    {
      $sql = "CREATE DATABASE meetings";

      if ($conn->query($sql) === TRUE)
      {
        echo "Database created successfully";
      }
      else
      {
        echo "Error creating database: " . $conn->error;
      }
    }
}
?>
