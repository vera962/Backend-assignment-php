<!-- index.php -->
<?php
 include('../Controllers/controller.php');
 require_once('../Models/Database.php');
 $model = new Database();
 // Initialize the Controler
 $controller = new Controller($model);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>User Management</h1>
    <div class="container">
    <form method="POST">
        <label for="data_option"></label>
        <select name="data_option" id="data_option">
        <optgroup label="Users Options">
            <option value="selectAllUsers">Select All Users</option>
            <option value="selectUserById">Select User by id</option>
            <option value="deleteUserById"> Delete User By Id</option>
        </optgroup>
        </select>
        <br>
        <input type="text" name="option_id" placeholder="Enter ID">
        <input type="submit" value="Submit">
        </form>

        <br>
        <br>
        <form method="POST">
        <label for="data_option"></label>
        <select name="data_option" id="data_option">
            <option value="insertUser">Insert User</option>
            <!-- <option value="updateUser">Update User</option> -->
        </select>
        <br>
        <input type="text" name="name" placeholder="Enter name">
        <input type="text" name="email" placeholder="Enter email">

        <input type="submit" value="Submit User">
    </form>
    <br>
    <br>
    <form method="POST">
        <label for="data_option"></label>
        <select name="data_option" id="data_option">
            <option value="updateUser">Update User</option>
        </select>
        <br>
        <!-- <input type="text" name="name" placeholder="Enter name"> -->
        <input type="text" name="userId" placeholder="Enter userId">
        <input type="text" name="newName" placeholder="Enter newName">
        <input type="text" name="newEmail" placeholder="Enter newEmail">

        <input type="submit" value="Submit User">
    </form>
    <br>
    <br>
    <form method="POST">
        <label for="data_option"></label>
        <select name="data_option" id="data_option">

        <optgroup label="Posts Options">
            <option value="selectAllPosts">Select All Posts</option>
            <option value="selectPostById">Select Post By Id</option>
            <option value="deletePostById"> Delete Post By Id</option>
        </optgroup>
        </select>
        <br>
        <input type="text" name="option_id" placeholder="Enter ID">
        <input type="submit" value="Submit">
        </form>

        <br>
        <br>
        <form method="POST">
        <label for="data_option"></label>
        <select name="data_option" id="data_option">
            <option value="insertPost">Insert Post</option>
            <!-- <option value="updateUser">Update User</option> -->
        </select>
        <br>
        <input type="text" name="userId" placeholder="Enter userId">
        <input type="text" name="title" placeholder="Enter title">
        <input type="text" name="body" placeholder="Enter body">

        <input type="submit" value="Submit Post">
    </form>
    <br>
    <br>
        <form method="POST">
        <label for="data_option"></label>
        <select name="data_option" id="data_option">
            <option value="selectUsersAndTheirPosts">select Users And Their Posts</option>
        </select>
        <br>
        <input type="text" name="option_id" placeholder="Enter ID">
        <input type="submit" value="Submit">
        </form>
</div>
       

    <?php
           

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
      
        $fetchingUsers = $controller->fetchUsersAndInsertFromApi();
        $fetchingPosts = $controller->fetchPostsAndInsertFromApi();
       

        $data_option = $_POST["data_option"];
        $option_id = $_POST["option_id"];

        $name_option = $_POST["name"];
   
        $email_option = $_POST["email"];

        $title_option =$_POST['title'];
        $body_option =$_POST['body'];
        $option_userId =$_POST['userId'];



        $updated_name_option = $_POST["newName"];
        $updated_email_option = $_POST["newEmail"];
        $user_id = $_POST["userId"];

        if (strpos($data_option, 'User') !== false) {
          
        if ($data_option === "selectAllUsers") {
             // Call the selectUsers() function from the controller
            $users = $controller->selectUsers();

            if (!empty($users)) {
                echo '<h2>All Existing Users are </h2>';
                echo '<ul>';
                foreach ($users as $user) {
                    echo '<li>';
                    echo 'User ID: ' . $user['id'] . '<br>';
                    echo 'Name: ' . $user['name'] . '<br>';
                    echo 'Email: ' . $user['email'] . '<br>';
                    echo 'DateOfBirth:' .$user['DateOfBirth'] .'<br>';
                    echo 'Available:' .$user['Available'] .'<br>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No users found.';
            }
        } elseif ($data_option === "selectUserById") {
            $user = $controller->selectUser($option_id);

            if ($user) {
                echo '<h2>User Details</h2>';
                echo 'User id: ' . $user['id'] . '<br>';
                echo 'Name: ' . $user['name'] . '<br>';
                echo 'Email: ' . $user['email'] . '<br>';
            } else {
                echo 'User not found.';
            }

        } 
        elseif ($data_option === "insertUser") {
            $user = $controller->insertUser($name_option, $email_option);
            echo "try to insert user :($user)";

            if ($user) {
                echo 'Successfully inserted!';
            } else {
                echo 'User was not inserted.';
            }

        } 
        elseif ($data_option === "updateUser") {
            $user = $controller->updateUser($user_id, $updated_name_option, $updated_email_option);
            echo "try to insert user :($user)";

            if ($user) {
                echo 'Successfully inserted!';            
            } else {
                echo 'User was not inserted.';
            }

        } 
        elseif ($data_option === "deleteUserById") {
            $user = $controller->deleteUser($option_id);

            if ($user) {
                echo '<h2>Deleted user details</h2>';
                echo 'User id: ' . $user['id'] . '<br>';
                echo 'Name: ' . $user['name'] . '<br>';
                echo 'Email: ' . $user['email'] . '<br>';
            } 
        }
        if ($data_option === "selectUsersAndTheirPosts") {          
            $usersAndPosts =$controller->selectUsersAndTheirPosts();
            if (!empty($usersAndPosts)) {
                echo '<h2>All Available Users and Their Posts are: </h2>';
                echo '<ul>';
                
                foreach ($usersAndPosts as $userAndPost) {
                    echo '<li>';
                    echo "<br>";
                    echo 'User ID: ' . $userAndPost['id'] . '<br>';
                    echo 'Name: ' . $userAndPost['name'] . '<br>';
                    echo 'Email: ' . $userAndPost['email'] . '<br>';
                    echo 'DateOfBirth:' . $userAndPost['DateOfBirth'] . '<br>';
                    echo 'Available:' . $userAndPost['Available'] . '<br>';
                    echo 'Image: <img src="../../resources/image.jpg">';
                    echo "<br>";
                    echo "<h2>Users posts: </h2>";
                    echo " Title: " . $userAndPost['title'] ."<br>" ;
                    echo "<p1>Body: " . $userAndPost['body'] . "</p1>" . "<br>";
                    echo "Available: " . $userAndPost['Available'];

                    echo '</li>';
                }    
                echo '</ul>';
            }
       }
    } 
        elseif (strpos($data_option, 'Post') !== false) {

            if ($data_option === "selectAllPosts") {
                $posts = $controller->selectPosts();
                if (!empty($posts)) {
                    echo '<h2>All Existing Posts are </h2>';
                    echo '<ul>';
                    foreach ($posts as $post) {
                        echo '<li>';
                        echo 'Post ID: ' . $post['id'] . '<br>';
                        echo 'Title: ' . $post['title'] . '<br>';
                        echo 'body: ' . $post['body'] . '<br>';
                        echo 'userId: ' . $post['userId'] . '<br>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'No users found.';
                }
        }elseif ($data_option === "selectPostById") {
            $post = $controller->selectPost($option_id);
            if ($post) {
                echo '<h2>Post Details</h2>';
                echo 'Post id: ' . $post['id'] . '<br>';
                echo 'Title: ' . $post['title'] . '<br>';
                echo 'Body: ' . $post['body'] . '<br>';
            } else {
                echo 'Post not found.';
            }

        }elseif ($data_option === "insertPost") {
            $insert_post = $controller->insertPost($title_option, $body_option, $option_userId);
            if ($insert_post) {
                echo " post successfully inserted!";
            } else {
                echo 'Post was not inserted.';
            }

        }
        elseif ($data_option === "deletePostById") {
            $post = $controller->deletePost($option_id);
                // echo "DataOption is: ($data_option)<br>";
                // echo 'Deleted Post is:';
                // echo 'Post id' . $post['id'] .'<br>';
                // echo 'Title: ' . $post['title'] . '<br>';
                // echo 'Body: ' . $post['body'] . '<br>';
                // echo 'Available: ' . $post['Available'] . '<br>';
                // echo 'UserID: ' . $post['userId'] . '<br>';

            if ($post) {
                echo '<h2>Successfully Deleted.</h2>';
            }  else {
                echo 'Could not delete.';
            }
        }   
    }
}
    ?>
</body>
</html>