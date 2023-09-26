<?php
require_once('../Models/Database.php');

class Controller 
{

    private $model;

    public function __construct(Database $model)
    {
        $this->model = $model;
    }

    public function fetchUsersAndInsertFromApi()
    {
        $this->model->fetchUsersApiDataAndInsert();
    }

    public function fetchPostsAndInsertFromApi()
    {
        $this->model->fetchPostsApiDataAndInsert();
    }

    public function closeDatabaseConnection()
    {
        $this->model->closeConnection();
    }

    public function selectUser($user_id) {
        return $this->model->selectUser($user_id);
    }

    public function insertUser($name, $email) {  
        return $this->model->insertUser($name, $email);
  
      }
      public function updateUser($user_id, $newUsername, $newEmail) {
        return $this->model->updateUser($user_id,$newUsername, $newEmail);
      }

    public function deleteUser($user_id)  {
        return $this->model->deleteUser($user_id);
    }

    public function insertPost($title, $content, $user_id) 
    {
        return $this->model->insertPost($title, $content, $user_id);
    }

    public function selectPost($post_id)
    {
        return $this->model->selectPost($post_id);
    }
    public function deletePost($post_id) {
        return $this->model->deletePost($post_id);
    }
}

$model = new Database();
$controller = new Controller($model);
$controller->fetchUsersAndInsertFromApi();
$controller->fetchPostsAndInsertFromApi();

// // Insert a new user
// $newUserId = $controller->insertUser("Hen2 haviv","Hen2@karina.biz");
// echo "Inserted user : " . $newUserId . "<br>";
// if ($newUserId === "User inserted successfully") {
//     echo "User added successfully!";
// } elseif ($newUserId === "User already exists") {
//     echo "User already exists in the database.";
// } else {
//     echo "An error occurred while adding the user.";
// }


//selectUserFromExsitingUsers
$selectedUser = $controller->selectUser(9);
echo "Selected user: " . json_encode($selectedUser) . "<br>";

// Update the user's information
$updateResult = $controller->updateUser(10,"janne_doe", "jane@example.com");
echo 'res =' . $updateResult . "<br>". "Update result: " . ($updateResult ? "Success" : "Failed") . "<br>";

// // Delete a user by ID
$deleteResult = $controller->deleteUser(10);
echo "Delete result: " . ($deleteResult ? "Success" : "Failed") . "<br>";

######################E###################--------------POSTS--------------######################################3

//insert a new post

// $newPost = $controller->insertPost('NNN Post','This is a new post',22);
// echo "Inserted post ID: " . $newPost . "<br>";


$selectedPost = $controller->selectPost(1);
echo "Selected post is: " . json_encode($selectedPost) . "<br>";

$deletedPostResult = $controller->deletePost(98);
echo "Delete result: " . ($deletedPostResult ? "Success" : "Failed") ."<br>";

// SELECT posts
// $posts = $userdatabase->selectPosts();
// foreach ($posts as $post) {
//     echo "ID: {$post['id']}, Title: {$post['title']}, content: {$post['content']}, createdDay: {$post['createdDay']} ,available: {$post['available']}, user_id: {$post['user_id']}<br>";
// }

// Update the post's information
// $updateResult = $userdatabase->updatePost(1, "just breath", "Stay with me, lets just breath", "YES");
// echo 'res =' . $updateResult . "<br>". "Updated Post result: " . ($updateResult ? "Success" : "Failed") . "<br>";

$controller->closeDatabaseConnection();