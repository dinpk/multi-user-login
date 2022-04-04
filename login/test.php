<?php
    $users_json = '[
        {
        "username":"admin",
        "password":"$2y$10$9zwJHwGBcENB0SR0HEKgh.afmnPOkcR/XgF4OPcUMeIDsQSt9EvTG",
        "user_type":"admin",
        "permission_files":["index.php","page1.php","page2.php","page3.php"],
        "status":"active"
        },
        {
        "username":"john",
        "password":"$2y$10$9zwJHwGBcENB0SR0HEKgh.afmnPOkcR/XgF4OPcUMeIDsQSt9EvTG",
        "user_type":"regular",
        "permission_files":["index.php","page1.php","page3.php"],
        "status":"active"
        },
        {
        "username":"janet",
        "password":"$2y$10$9zwJHwGBcENB0SR0HEKgh.afmnPOkcR/XgF4OPcUMeIDsQSt9EvTG",
        "user_type":"regular",
        "permission_files":["index.php","page2.php","page3.php"],
        "status":"active"
        }
    ]';

    $users_array = json_decode($users_json, true);
    
    // Change password
    for ($i = 0; $i < count($users_array); $i++) {
        $user = $users_array[$i];
        if ($user["username"] == "john") {
            $users_array[$i]["password"] = '$2y$10$LJuRe44IK.lqS2A.Y2WiHeT68F0Zy7rMjDo5a5AdB5uvRWu8lMcjC';
            break;
        }
    }

    // Delete user
    for ($i = 0; $i < count($users_array); $i++) {
        $user = $users_array[$i];
        if ($user["username"] == "admin") {
            $message = "Can not delete";
            break;
        } else if ($user["username"] == "john") {
            $users_array[$i]["status"] = 'deleted';
            break;
        }
    }
    
    // Undelete user
    for ($i = 0; $i < count($users_array); $i++) {
        $user = $users_array[$i];
        if ($user["username"] == "john") {
            $users_array[$i]["status"] = 'active';
            break;
        }
    }

    // Set permission files
    $new_permission_files = ["index.php", "page1.php"];
    for ($i = 0; $i < count($users_array); $i++) {
        $user = $users_array[$i];
        if ($user["username"] == "janet") {
            $users_array[$i]["permission_files"] = $new_permission_files;
            break;
        }
    }
    
    // add new user
    $new_user["username"] = "philip";
    $new_user["password"] = '$2y$10$FK27VoEriP3PBkLAxoV5S.T3QlkldKHBisDx0MSGYsi5x8BNiX3xW';
    $new_user["user_type"] = "regular";
    $new_permission_files = ["index.php", "page1.php", "page2.php"];
    $new_user["permission_files"] = $new_permission_files;

    $users_array[] = $new_user;
    
    print "<pre>";
    var_dump($users_array);
    print "</pre>";

    /*
    $users_json_again = json_encode($users_array);
    print($users_json_again);
    */
?>