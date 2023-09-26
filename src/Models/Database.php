<?php error_reporting (E_ALL ^ E_NOTICE);
class Database{

    //initialization and connection of the database
    private $db_host = 'localhost';
    private $db_username = 'root';
    private $db_password = 'mysql';
    private $db_name = 'mydatabase';
    private $db_conn;

    public function __construct() {
        $this->db_conn = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_name);

        if ($this->db_conn->connect_error) {
            die("Connection failed: " . $this->db_conn->connect_error);
        }
        echo "Connected to Database!"."<br>";

    }

    public function selectUser($user_id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db_conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }


    public function insertUserId($id, $name, $email) {
        // Check if the user already exists based on id
        $check_query = "SELECT email FROM users WHERE email = ?";
        $check_stmt = $this->db_conn->prepare($check_query);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        // If a user with the same id exists, return a message or error code
        if ($check_stmt->num_rows > 0) {
            $check_stmt->close();
          //  return "User already exists"; // You can return an error message or code here
        }
        //$check_stmt->close();
        // Insert the user if they don't exist
        $insert_query = "INSERT INTO users (id, name, email) VALUES (?, ?, ?)";
        $stmt = $this->db_conn->prepare($insert_query);
        $stmt->bind_param("iss",$id, $name, $email);
        $stmt->execute();
        $res = $stmt->affected_rows;
        $stmt->close();
        
        if ($res > 0) {
            return "User inserted successfully";
        } else {
            return "User insertion failed";
        }
    }
    public function insertUser($name, $email) {
        $this->insertUserId(NULL, $name, $email);
    }


    // public function deleteUser($user_id) {
    //     $query = "DELETE FROM users WHERE id = ?";
    //     $stmt = $this->db_conn->prepare($query);
    //     $stmt->bind_param("i", $user_id);
    //     $stmt->execute();
    //     $stmt->close();
    //     return $this->db_conn->affected_rows;
    // }
    public function deleteUser($user_id) {

    // First, delete user's posts
    $query_posts_deletion = "DELETE FROM posts WHERE userId = ?";
    $stmt = $this->db_conn->prepare($query_posts_deletion);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Posts deleted successfully, now delete the user
        $query_users_deletion = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db_conn->prepare($query_users_deletion);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // User deleted successfully
            $stmt->close();
            $this->db_conn->commit();
            echo "User and associated posts have been deleted.";
        } else {
            throw new Exception("Error deleting user: " . $stmt->error);
        }
    } else {
        throw new Exception("Error deleting posts: " . $stmt->error);
    }

    }

    public function updateUser($user_id, $newUsername, $newEmail) {
        $query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $this->db_conn->prepare($query);
        $stmt->bind_param("ssi", $newUsername, $newEmail, $user_id);
        $stmt->execute();
        $stmt->close();
        return $this->db_conn->affected_rows;
    }

    public function selectPost($post_id) {
        $query = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->db_conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $post = $result->fetch_assoc();
        $stmt->close();
        return $post;
    }


    public function selectPosts() {
        $query = "SELECT * FROM posts";
        $result = $this->db_conn->query($query);
        $posts = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }
        return $posts;
    }


    public function insertPostId($id, $title, $body, $user_id) {
        
        // Check if the id already exists in the database
        $check_query = "SELECT id FROM posts WHERE id = ?";
        $check_stmt = $this->db_conn->prepare($check_query);
        if (!$check_stmt) {
            die('Prepare statement failed: ' . $this->db_conn->error);
        }
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        // If a row with the same name exists, skip insertion
        if ($check_stmt->num_rows > 0) {
            $check_stmt->close();
           // echo "Id '$id' already exists. Skipping insertion.<br>";
        } else {
            // Insert the data if the name doesn't exist
            $insert_query = "INSERT INTO posts (id, title, body, userId) VALUES (?, ?, ?, ?)";
            $stmt = $this->db_conn->prepare($insert_query);
            if (!$stmt) {
                die('Prepare statement failed: ' . $this->db_conn->error);
            }
            $stmt->bind_param("issi", $id, $title, $body, $user_id);
            echo "userID is ", $user_id;
            if (!$stmt->execute()) {
                die('Failed to insert data: ' . $stmt->error);
            }
            $stmt->close();
        }
        //$check_stmt->close();
    }


    public function insertPost($title, $body, $user_id) {
            $this->insertPostId(NULL, $title, $body, $user_id);
    }
        
    public function updatePost($id, $title, $content, $available) {
        $query = "UPDATE posts SET title = ?, content = ?, available = ? WHERE id = ?";
        $stmt = $this->db_conn->prepare($query);
        $stmt->bind_param("sssi", $title, $content, $available, $id);
        return $stmt->execute();
    }

    public function deletePost($id) {
        $query = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->db_conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    // fetching user data from the url of Fake Rest Api
    public function fetchUsersApiDataAndInsert(){
        $api_url = 'https://jsonplaceholder.typicode.com/users'; 
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
    
        if ($response === false) {
            die('Failed to fetch data from the API: ' . curl_error($ch));
        }
        curl_close($ch);
        $data = json_decode($response, true); // Assuming the API returns JSON data
        foreach ($data as $item) {
            $id = $item['id'];
            $name = $item['name']; 
            $email = $item['email'];
            
            $this->insertUserId($id,$name,$email);
        }
    }

    // fetching post data from the url of Fake Rest Api
    public function fetchPostsApiDataAndInsert(){
        $api_url = 'https://jsonplaceholder.typicode.com/posts'; 
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
    
        if ($response === false) {
            die('Failed to fetch data from the API: ' . curl_error($ch));
        }
        curl_close($ch);
        $data = json_decode($response, true); // Assuming the API returns JSON data
        foreach ($data as $item) {
            $id = $item['id'];
            $title = $item['title']; 
            $body = $item['body'];
            $user_id = $item['userId'];

            $this->insertPostId($id, $title, $body, $user_id);
        }
    }

    public function closeConnection() {
        $this->db_conn->close();
    }

}

?>