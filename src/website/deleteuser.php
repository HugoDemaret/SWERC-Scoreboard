<?php
// load users from json file
$users = json_decode(file_get_contents('/var/data/users.json'), true);

// get username to delete
$username = $_POST['username'];

// remove user from array
if (isset($users[$username])) {
    unset($users[$username]);

    // save updated users to json file
    file_put_contents('/var/data/users.json', json_encode($users));

    // redirect back to user list
    header('Location: modifyuser.php');
    exit();
} else {
    // user not found
    echo 'User not found';
}
?>
