<!-- index.php -->

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
</head>
<body>
    <h1>User Management</h1>

    <form method="POST">
        <label for="data_option">Select an option For User:</label>
        <select name="data_option" id="data_option">
        <optgroup label="Users Options">
            <option value="selectAllUsers">Select All Users</option>
            <option value="selectUserById">Select User by id</option>
            <option value="deleteUserById"> Delete User By Id</option>
        </optgroup>
        <optgroup label="Posts Options">
            <option value="selectAllPosts">Select All Posts</option>
            <option value="selectPostById">Select Post By Id</option>
            <option value="insertPost">Insert Post By id</option>
            <option value="updatePost"> update Post</option>
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
        <label for="data_option">insert User:</label>
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
        <label for="data_option">Update User:</label>
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
       
       <?php
        // Check if the selected option is "insertUser" to display additional fields
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["data_option"] === "insertUser") {
        ?>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter Name">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter Email">
        <br>
        <input type="submit" value="Submit">

        <?php
        }
        ?>
             <?php
        // Check if the selected option is "insertUser" to display additional fields
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["data_option"] === "updateUser") {
        ?>
        <label for="userId">userId:</label>
        <input type="text" name="userId" id="userId" placeholder="Enter userId">
        <br>
        <label for="newName">Name:</label>
        <input type="text" name="newName" id="newName" placeholder="Enter UpdatedName">
        <br>
        <label for="newEmail">Email:</label>
        <input type="newEmail" name="newEmail" id="newEmail" placeholder="Enter UpdatedEmail">
        <br>
        <input type="submit" value="Submit">

        <?php
        }
        ?>

    <?php


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        include('../Controllers/controller.php');
        require_once('../Models/Database.php');


        $model = new Database();
        // Initialize the Controler
        $controller = new Controller($model);

        $data_option = $_POST["data_option"];
        $option_id = $_POST["option_id"];

        $name_option = $_POST["name"];
        echo "name is: ",$name_option;
   
        $email_option = $_POST["email"];
        echo "email is: ",$email_option;


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
            echo "Am I inside insertedUser?";
            $user = $controller->insertUser($name_option, $email_option);
            echo "try to insert user :($user)";

            if ($user) {
                echo 'Successfully inserted!';
                echo '<h2>User Details</h2>';
                echo 'User id: ' . $user['id'] . '<br>';
                echo 'Name: ' . $user['name'] . '<br>';
                echo 'Email: ' . $user['email'] . '<br>';
            } else {
                echo 'User was not inserted.';
            }

        } 
        elseif ($data_option === "updateUser") {
            echo "Am I inside updatedUser?";
            $user = $controller->updateUser($user_id, $updated_name_option, $updated_email_option);
            echo "try to insert user :($user)";

            if ($user) {
                echo 'Successfully inserted!';
                echo '<h2>User Details</h2>';
                echo 'User id: ' . $user['id'] . '<br>';
                echo 'Name: ' . $user['name'] . '<br>';
                echo 'Email: ' . $user['email'] . '<br>';
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
        }elseif (strpos($data_option, 'Post') !== false) {
            echo "Am I in Posts?";
            echo "DataOption is: ($data_option)";

            if ($data_option === "selectAllPosts") {
                echo "Am I in Posts check 2?";
                echo "DataOption is: ($data_option)";
                $posts = $controller->selectPosts();
                echo "Am I in Posts check 2?";
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
                echo 'Body: ' . $user['body'] . '<br>';
            } else {
                echo 'Post not found.';
            }

        } elseif ($data_option === "deletePostById") {
            echo "Am I in Posts check 2?";
                echo "DataOption is: ($data_option)";
                $post = $controller->deletePost($option_id);
                echo "Am I in Posts check 2?";
                echo "DataOption is: ($data_option)";
                echo " Deleted Post is: ($post)";
                if ($post) {
                    echo '<h2>Successfully Deleted.</h2>';
                    // echo 'Post id: ' . $post['id'] . '<br>';
                    // echo 'Title: ' . $post['title'] . '<br>';
                    // echo 'Body: ' . $post['body'] . '<br>';
                }  else {
                    echo 'Could not delete.';
                }
        }   
    }
}
    ?>
</body>
</html>