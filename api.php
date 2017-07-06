<?php

	header('Access-Control-Allow-Origin: *');  

	$db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "databaseTest";

    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die("Some error occurred during connection " . mysqli_error($conn));

    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if ($_GET["func"] == 'getStud')
        {
            getAllEmployees();
        }

        if ($_GET["func"] == 'id')
        {
            getByID($_GET["ID"]);
        }

        if ($_GET["func"] == 'letters')
        {
            getByName($_GET["name"]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if($_POST["func"] == 'login')
        {
            login();
        }

        if($_POST["func"] == 'changePass')
        {
            changePass();
        }

        if($_POST["func"] == 'regist')
        {
            register();
        }
    }

    function getAllEmployees() {
        global $conn;
        $sql = "SELECT * FROM employees";

        $result = mysqli_query($conn, $sql);
        if($result)
        {
            $employees = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $employee = array();
                $employee['ID'] = $row['ID'];
                $employee['name'] = $row['name'];
                $employee['gender'] = $row['gender'];
                $employee['salary'] = $row['salary'];
                $employees[] = $employee;
            }
            echo json_encode($employees);
        }
        else
        {
        	echo mysqli_error($conn);
        }
    }

    function getByID($id) {

        global $conn;
        
        $sql = "SELECT * FROM employees WHERE ID=" . $id;

        $result = mysqli_query($conn, $sql);
        if($result)
        {
            $employees = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $employee = array();
                $employee['ID'] = $row['ID'];
                $employee['name'] = $row['name'];
                $employee['gender'] = $row['gender'];
                $employee['salary'] = $row['salary'];
                $employees[] = $employee;
            }

            echo json_encode($employees);

        }
        else
        {
            echo mysqli_error($conn);
        }
    }

    function getByName($name) {

        global $conn;

        $sql = "SELECT * FROM employees WHERE name LIKE '%" . $name . "%'";

        $result = mysqli_query($conn, $sql);
        if($result)
        {
            $employees = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $employee = array();
                $employee['ID'] = $row['ID'];
                $employee['name'] = $row['name'];
                $employee['gender'] = $row['gender'];
                $employee['salary'] = $row['salary'];
                $employees[] = $employee;
            }

            echo json_encode($employees);

        }
        else
        {
            echo mysqli_error($conn);
        }
    }

    function login() {

        global $conn;

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM `users` WHERE username='$username' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $response['status'] = 'loggedin';
            $response['user'] = $username;
            $response['useruniqueid'] = md5(uniqid());
            $_SESSION['useruniqueid'] = $response['useruniqueid'];
        } else {
            $response['status'] = 'error';
        }

        echo json_encode($response);
    }

    function changePass() {
        global $conn;

        $newPass = mysqli_real_escape_string($conn, $_POST['newPass']);
        $username = mysqli_real_escape_string($conn, $_POST['user']);

        // $sql = "UPDATE users SET password = '$newPass' WHERE username = '".$_SESSION['user']."'";
        $sql = "UPDATE users SET password = '$newPass' WHERE username = '$username'";

        $result = mysqli_query($conn, $sql);

        if($result) {
            $response['status'] = 'done';
        } else {
            $response['status'] = 'error';
        }

        echo json_encode($response);
    }

    function register() {
        
    }

?>
