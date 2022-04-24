<?php
require '../config.php';
$flag = false;
$updateFlag = false;
$userName = $email = $password = $room = $exten = $hidden_id = $user = $is_admin = "";
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); // htmlspecialchars() converts special characters to HTML entities
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    // $hash = password_hash($password,PASSWORD_DEFAULT);
    $room = test_input($_POST['room']);
    $exten = test_input($_POST['ext']);
    $hidden_id = test_input($_POST['hidden_id']);
    if (empty($_POST['admin'])) {
        $is_admin = '0';
    } else {
        $is_admin = test_input($_POST['admin']);
    }

    if (isset($_FILES['image'])) {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $ext = explode('.', $_FILES['image']['name']);
        $file_ext = strtolower(end($ext));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }
        if ($file_size > 2097152) {
            $errors[] = 'File size must be lower than 2 MB';
        }
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "../images/" . $file_name);
        } else {
            print_r($errors);
        }
    }
    #select users from db
    $sql = "SELECT user_id,username FROM user";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    #insert into db
    if ($hidden_id == "") {
        foreach ($result as $names) {
            if ($names['username'] == $userName) {
                $flag = true;
                break;
            }
        }
        if ($flag == true) {
            $user = "notAccepted";
            header('Location: addUser.php?user=' . $user . '');
        } else {
            $sql = "INSERT INTO user (username,password,email,room,ext,profile_pic,is_admin) Values(?,?,?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$userName, $password, $email, $room, $exten, "/cafeteria-project-iti/images/" . $_FILES['image']['name'], $is_admin]);
            $user = "accepted";
            header('Location: addUser.php?user=' . $user . '');
        }
        #update user data
    } else {
        foreach ($result as $names) {
            if ($names['username'] == $userName) {
                if ($names['user_id'] == $hidden_id) {
                    continue;
                } else {
                    $updateFlag = true;
                    break;
                }
            }
        }
        if ($updateFlag == false) {
            $sql = "UPDATE user SET username=?,password=?,email=?,room=?,ext=?,profile_pic=?,is_admin=? WHERE user_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$userName, $password, $email, $room, $exten, "/cafeteria-project-iti/images/" . $_FILES['image']['name'], $is_admin, $hidden_id]);
            $user = "accepted";
            header('Location: allUsers.php');
        }
    }
}
$db = null;
