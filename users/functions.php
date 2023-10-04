<?php

session_start();

require_once('dbconnect.php');

$errors = array();

if (isset($_POST['register'])) {
    register();
}

if (isset($_POST['login'])) {
    login();
}

if (isset($_POST['updatePass'])) {
    updatePassword();
}

if (isset($_POST['logoutsubmit'])) {
    logout();
}

// REGISTER USER
function register() {
    global $link, $errors;

    $username = $_POST['uname'];
    $email = $_POST['email'];
    $password_1 = $_POST['upass1'];
    $password_2 = $_POST['upass2'];

    validateRegistrationForm($username, $email, $password_1, $password_2);

    $user_check_query = "SELECT * FROM user WHERE uname='$username' OR email='$email' LIMIT 1";
    $user = fetchUser($user_check_query);

    if ($user) {
        if ($user['uname'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);
        $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

        $query = "INSERT INTO user (uname, email, upass, user_type) 
                  VALUES('$username', '$email', '$password', '$user_type')";
        executeQuery($query);

        $_SESSION['success'] = "New user successfully created!!";
        header('location:login.php');
    }
}

function validateRegistrationForm($username, $email, $password_1, $password_2) {
    global $errors;

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
}

function fetchUser($query) {
    global $link;
    $result = mysqli_query($link, $query);
    return mysqli_fetch_assoc($result);
}

function executeQuery($query) {
    global $link;
    mysqli_query($link, $query);
}

// LOGIN USER
function login() {
    global $errors, $link;

    $email = $_POST['email'];
    $password = $_POST['upass'];

    validateLoginForm($email, $password);

    $password = md5($password);
    $query = "SELECT * FROM user WHERE email='$email' AND upass='$password' LIMIT 1";
    $results = mysqli_query($link, $query);

    if (mysqli_num_rows($results) == 1) {
        $logged_in_user = mysqli_fetch_assoc($results);
        if ($logged_in_user['user_type'] == 1) {
            $_SESSION['user'] = $logged_in_user;
            $_SESSION['success'] = "You are now logged in";
            header('location: ../admin/home.php');
        } else {
            $_SESSION['user'] = $logged_in_user;
            $_SESSION['success'] = "You are now logged in";
            header('location: homepage.php');
        }
    } else {
        array_push($errors, "Wrong email/password combination");
    }
}

function validateLoginForm($email, $password) {
    global $errors;

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
}

function updatePassword() {
    global $link;

    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
    $rePass = $_POST['rePass'];

    if ($newPass !== $rePass) {
        echo "New password and Repassword does not match.";
    } else {
        $user_query = "SELECT * FROM user WHERE uid=1";
        $oldPassHash = md5($oldPass);
        $user = fetchUser($user_query);

        if ($oldPassHash == $user['upass']) {
            $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);
            $update_query = "UPDATE user SET upass='$newPassHash' WHERE uid=1";
            executeQuery($update_query);
        } else {
            echo "Old password does not match.";
        }
    }
}

function logout() {
    session_destroy();
    header('location: ../index.php');
}

function display_error() {
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['user_type'] == '1';
}

?>
