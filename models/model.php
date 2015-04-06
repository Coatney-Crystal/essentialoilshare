<?php

require 'connect.php';

function registerUser($firstname, $lastname, $password, $email) {
    $db = connect();


    try {
        $query = "Insert into user (firstname, lastname, password, email) values (:firstname, :lastname, :password, :email) ";

        $statement = $db->prepare($query);
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $userid = $db->lastInsertId();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
}

function login($email, $password) {
    $db = connect();


    try {
        $query = "Select * FROM user WHERE email = :email AND password = :password";
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $success = $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }


//switch ($action){
//    case 'login':
//        $email = $_POST ['email'];
//        $password = $_POST ['password'];
//        if (is_valid_admin_login($email, $password)){
//         $_SESSION['is_valid-admin'] = true;
//            include ('view/admin_menu.php');
//           
//        }
//        else{
//            $login_message = 'You must login to view this page.';
//            include ('view/login.php');
//        }
}

function updatename($firstname, $lastname, $userid) {
    $db = connect();
    try {
        $query = "update user set firstname = :firstname, lastname = :lastname WHERE user_id = :userid";

        $statement = $db->prepare($query);
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function chagnepassword($currentpassword, $newpassword, $userid) {
    $db = connect();
    try {
        $query = "update user set password = :newpassword WHERE user_id = :userid AND password= :currentpassword";

        $statement = $db->prepare($query);
        $statement->bindValue(':currentpassword', $currentpassword);
        $statement->bindValue(':newpassword', $newpassword);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function deleteaccount($userid) {
    $db = connect();
    try {
        $query = "update user set active = 0 WHERE user_id = :userid";

        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function add_admin($userid) {
    $db = connect();
    try {
        $query = "update user
         SET permission = 'admin' WHERE user_id = :userid";
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
}

function GetAllUsers() {
    $db = connect();


    try {
        $query = "Select * FROM user WHERE active = 1";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}

function getselecteduser($userid) {
    $db = connect();

    try {
        $query = "Select * FROM user WHERE user_id =:userid";
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}

// Save a new Item
// $name - the name of the item.
// $imageUrl - a URL to the item image.
function SaveNewItem($name, $imageUrl) {
    $query = "INSERT INTO items(Name, ImageUrl, createdBy) VALUES(:name, :url, :userId)";
    $id = DbInsert($query, array(':name' => $name, ':url' => $imageUrl, ':userId' => login()));
    return $id;
}

function GetItemById($id) {
    $query = "SELECT * FROM items WHERE ID=:id";
    $result = DbSelect($query, array(':id' => $id));

    if (array_key_exists(0, $result)) {
        return $result[0];
    }

    return false;
}

function changepermission($userid, $permission) {
    $db = connect();
    try {
        $query = "update user
         SET permission = :permission WHERE user_id = :userid";
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->bindValue(':permission', $permission);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function GetAllContent() {
    $db = connect();


    try {
        $query = "Select * FROM category WHERE active = 1";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}

function getselectedcontent($category_id) {
    $db = connect();

    try {
        $query = "Select * FROM category WHERE category_id =:category_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}

function updatetitle($title, $category_id) {
    $db = connect();
    try {
        $query = "update category set title = :title WHERE category_id = :category_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function updatedescription($description, $category_id) {
    $db = connect();
    try {
        $query = "update category set description = :description WHERE category_id = :category_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function updateparagraph($paragraph, $category_id) {
    $db = connect();
    try {
        $query = "update category set paragraph = :paragraph WHERE category_id = :category_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':paragraph', $paragraph);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function updatepage($page, $category_id) {
    $db = connect();
    try {
        $query = "update category set page = :page WHERE category_id = :category_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':page', $page);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    } updatenavigation($page, $category_id);
    return $rows;
}

function deletepage($category_id) {
    $db = connect();
    try {
        $query = "update category set active = 0 WHERE category_id = :category_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function addcategory($title, $description, $paragraph, $uniquename) {
    $db = connect();


    try {
        $query = "Insert into category (title, description, paragraph, page) values (:title, :description, :paragraph, :page) ";

        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':paragraph', $paragraph);
        $statement->bindValue(':page', $uniquename);
        $statement->execute();
        $categoryid = $db->lastInsertId();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    if ($categoryid) {
        addnavigation($uniquename, $categoryid);
        return $categoryid;
    } else {

        return FALSE;
    }
}

function updatenavigation($page, $category_id) {
    $db = connect();
    $href = '?page=' . $page;
    try {
        $query = "update navigation set href = :href WHERE category_id = :category_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':href', $href);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function addnavigation($page, $category_id) {
    $db = connect();

    $href = '?page=' . $page;
    try {
        $query = "Insert into navigation (category_id, href) values (:category_id, :href) ";

        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':href', $href);
        $statement->execute();
        $navigation_id = $db->lastInsertId();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    if ($navigation_id) {
        return $navigation_id;
    } else {

        return FALSE;
    }
}
function GetNavigation() {
    $db = connect();


    try {
        $query = "Select c.title, n.href, c.category_id FROM category c inner join navigation n using(category_id) WHERE c.active = 1";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}

function GetUsersImages($userid) {
    $db = connect();


    try {
        $query = "Select * FROM images WHERE active = 1 AND user_id = :userid ";
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }

    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}
function  addimage($image, $description, $alttext, $categorydropdown, $name, $type, $userid){
    $db = connect();
  
    try {
        $query = "Insert into images (category_id, user_id, image, description, alt, name, type) values (:category_id, :user_id, :image, :description, :alt, :name, :type) ";

        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $categorydropdown);
        $statement->bindValue(':user_id', $userid);
        $statement->bindValue(':image', $image);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':alt', $alttext);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':type', $type);
        $statement->execute();
        $image_id = $db->lastInsertId();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    if ($image_id) {
        return $image_id;
    } else {

        return FALSE;
    }
}
function getselectedimage($imageid) {
    $db = connect();

    try {
        $query = "Select * FROM images WHERE imageid = :imageid";
        $statement = $db->prepare($query);
        $statement->bindValue(':imageid', $imageid);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}


function updateimage($alttext, $description, $categorydropdown, $imageid ){
    $db = connect();
    
    try {
        $query = "update images set alt=:alttext, description =:description, category_id= :categorydropdown WHERE imageid = :imageid";

        $statement = $db->prepare($query);
        $statement->bindValue(':imageid', $imageid);
         $statement->bindValue(':alttext', $alttext);
          $statement->bindValue(':description', $description);
           $statement->bindValue(':categorydropdown', $categorydropdown);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}

function deleteimage($imageid) {
    $db = connect();
    try {
        $query = "update images set active = 0 WHERE imageid = :imageid";

        $statement = $db->prepare($query);
        $statement->bindValue(':imageid', $imageid);
        $statement->execute();
        $rows = $statement->rowcount();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
    return $rows;
}
function GetImages($categoryid) {
    $db = connect();

    try {
        $query = "Select * FROM images WHERE category_id = :categoryid ORDER by date_added";
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryid', $categoryid);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
    } catch (Exception $ex) {
        header('location: ./error.php');
        exit;
    }
   
    if (!empty($result)) {

        return $result;
    } else {

        return FALSE;
    }
}