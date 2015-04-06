<?php

session_start();
include 'models/model.php';
include 'library/library.php';

if (isset($_POST['page'])) {
    $page = $_POST['page'];
} elseif (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home';
}

if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
} elseif (isset($_GET['submit'])) {
    $submit = $_GET['submit'];
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if (isset($_POST['user'])) {
    $userid = $_POST['user'];
} elseif (isset($_GET['user'])) {
    $userid = $_GET['user'];
}
if (isset($_POST['category'])) {
    $category_id = $_POST['category'];
} elseif (isset($_GET['category'])) {
    $category_id = $_GET['category'];
}
if (isset($_POST['imageid'])) {
    $imageid = $_POST['imageid'];
} elseif (isset($_GET['imageid'])) {
    $imageid = $_GET['imageid'];
}


if ($page == 'home') {
    
} else if ($page == 'register') {
    $title = 'register';
    $content = '<form action = ".?page=register" method = "POST">' .
            'firstname: <input type= "text" name= "firstname" required/><br>' .
            'lastname: <input type= "text" name= "lastname" required/><br>' .
            'password: <input type= "text" name= "password" required/><br>' .
            'email: <input type= "text" name= "email" required/><br>' .
            '<button type= "submit" name= "submit" value="register">register</button>' .
            '</form>';



    if ($submit == 'register') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if ($action == 'register'){
     $firstname = (string)$_POST['firstname'];
    $lastname = (string)$_POST['lname'];
    $email = (string)$_POST['email'];
    $password = (string)$_POST['pasword'];  
    //verify aounts
    
    $e = '';
    $cf = strlen($firstname);
    $cl = strlen($lastname);
    $ce = strlen($email);
    $cp = strlen($password);

    if ($cu == 0 || $cf == 0 || $cl == 0 || $ce == 0 || $cp == 0) {
      $e .= "Inputs cannot be blank.<br>";
    }
    if ($cu < 5) {
      $e .= "Username must be at least 5 characters long.<br>";
    }
    if ($cp < 8) {
      $e .= "Password must be at least 8 characters long.<br>";
    }
    if ($ce < 5){
      $e .= "Email cannot be less than 5 characters long.<br>";
    }
    if (!empty($e)) {
      $error = $e;
    }
    if (empty($error)) {
      $firstname = filterName($firstname);
      $lastname = filterName($lastname);
      $email = remove_tags($email1);
      $result = validateEmail($email);
      //Make sure username doesn't have spaces.
      if ($user === FALSE) {
        if (!empty($pword1) && !empty($email) && !empty($lname) && !empty($fname) && $fname != FALSE && $lname != FALSE && $result != FALSE) {
          $success = add_person( $fname, $lname, $email, $pword1, $sOrT);

          if ($success == 0) {
            $error = "We're sorry but the register attempt failed. Please try again.";
          } elseif ($success == 2) {
            $error = "Username already taken, please use another.";
          } else {
            header('Location: /?page=login');
            exit;
          }
        } else {
          $error = "Invalid input. Please try again.";
        }
      } else {
        $error = 'Please do not include spaces in username.';
      }
    }
  }
    
        }
        registerUser($firstname, $lastname, $password, $email);
    }
 else if ($page == 'login') {
    $title = 'login';
    $content = '<form action = ".?page=login" method = "POST">' .
            'Email Address: <input type="text" name="email" id="email" /><br />' .
            'Password: <input type="password" name="password" id="password" /><br />' .
            '<button type= "submit" name= "submit" value="login">Login</button>' .
            '</form>';
    if ($submit == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = login($email, $password);
        if ($result) {
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['lastname'] = $result['lastname'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['permission'] = $result['permission'];
            $_SESSION['active'] = $result['active'];
            $_SESSION['userid'] = $result['user_id'];

            header('Location: /');
        } else {
            $error = "invalid username and or password";
        }
    }
} elseif ($page == 'logout') {
    $_SESSION['firstname'] = NULL;
    $_SESSION['lastname'] = NULL;
    $_SESSION['email'] = NULL;
    $_SESSION['permission'] = NULL;
    $_SESSION['active'] = NULL;
    $_SESSION['userid'] = NULL;
    header('Location: /');
} elseif ($page == 'account') {
    $title = 'account';
    $content = '<form action =".?page=account" method="POST">
    <h3>Update Name</h3>
    firstname <input type="text" name="firstname" value="' . $_SESSION['firstname'] . '" required/> 
    lastname <input type="text" name="lastname" value="' . $_SESSION['lastname'] . '" required/> 
    <button type="submit" name="submit" value="updatename"> Update</button>
    
    
</form>

<form action =".?page=account" method="POST">
    <h3>Change Password</h3>
    currentpassword <input type="password" name="currentpassword" required/> 
    newpassword <input type="password" name="newpassword"  required/> 
    <button type="submit" name="submit" value="newpassword"> Update</button>
    
</form>

<form action =".?page=account" method="POST">
    <h3>delete account</h3>
    <button type="submit" name="submit" value="deleteaccount"> Delete Account</button>
    
</form>
';
    if ($submit == 'updatename') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $userid = $_SESSION['userid'];
        $result = updatename($firstname, $lastname, $userid);
        if ($result == 1) {
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            header('Location: /?page=account');
        } else {
            $error = "no change made";
        }
    } elseif ($submit == 'newpassword') {
        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $userid = $_SESSION['userid'];
        $result = chagnepassword($currentpassword, $newpassword, $userid);
        if ($result == 0) {
            $error = "incorrect password, no change made";
        } else {
            $error = "Password change successful";
        }
    } elseif ($submit == 'deleteaccount') {
        $userid = $_SESSION['userid'];
        $result = deleteaccount($userid);
        if ($result == 1) {
            header('Location: /?page=logout');
        }
    }
} else if ($page == 'client') {

    $title = 'Client Management System';
    $content = builduserslist();
    if ($action == 'edit') {

        if ($submit == 'updatename') {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $success = updatename($firstname, $lastname, $userid);
            if ($success == 1) {
                $error = "change successful";
            } else {
                $error = "no change made";
            }
        } elseif ($submit == 'makeadmin') {
            $permission = 'admin';
            $rows = changepermission($userid, $permission);
            if ($rows == 1) {
                $error = "change successful";
            } else {
                $error = 'no change made';
            }
        } elseif ($submit == 'makeuser') {
            $permission = 'user';
            $rows = changepermission($userid, $permission);
            if ($rows == 1) {
                $error = "change successful";
            } else {
                $error = 'no change made';
            }
        } elseif ($submit == 'deleteaccount') {
            $success = deleteaccount($userid);
            if ($success == 1) {
                header('Location: /?page=client');
            } else {
                $error = "no change made";
            }
        }$result = getselecteduser($userid);
        $content .= '<h3>edit user</h3>';
        $content .= '<form action =".?page=client&amp;action=edit&amp;user=' . $userid . '" method="POST">
    <h3>Update Name</h3>
    firstname <input type="text" name="firstname" value="' . $result['firstname'] . '" required/> 
    lastname <input type="text" name="lastname" value="' . $result['lastname'] . '" required/> 
    <button type="submit" name="submit" value="updatename"> Update</button>
    
    
</form>

<form action =".?page=client&amp;action=edit&amp;user=' . $userid . '" method="POST">
    <h3>Admin Rights</h3>
    current status ' . $result['permission'] . '
    <button type="submit" name="submit" value="makeadmin"> Make Admin</button>   
    <button type="submit" name="submit" value="makeuser"> Make User</button>
    
</form>

<form action =".?page=client&amp;action=edit&amp;user=' . $userid . '" method="POST">
    <h3>delete account</h3>
    <button type="submit" name="submit" value="deleteaccount"> Delete Account</button>
    
</form>
';
    }
} elseif ($page == 'content') {
    $title = 'content managment system';
    $content = buildcontentlist();
    $content.= '<form action =".?page=content&amp;action=add" method="POST">
    <h3>Add New Category</h3>
    title <input type="text" name="title" value="" required/> <br> 
    description <input type="text" name="description" value="" required/><br> 
     paragraph <textarea  name="paragraph"  required></textarea> <br> 
     add unique page name <input type="text" name="uniquename" value="" required/> <br>
    <button type="submit" name="submit" value="add"> Add</button>
    
</form>';
    if ($submit == 'add') {
        $pagetitle = $_POST['title'];
        $description = $_POST['description'];
        $paragraph = $_POST['paragraph'];
        $uniquename = $_POST['uniquename'];
        $success = addcategory($pagetitle, $description, $paragraph, $uniquename);
        if ($success != FALSE) {
            header('Location: /?page=content');
        } else {
            $error = "no change made";
        }
    }

    if ($action == 'edit') {


        if ($submit == 'updatetitle') {
            $pagetitle = $_POST['title'];

            $success = updatetitle($pagetitle, $category_id);
            if ($success == 1) {
                header('Location: /?page=content&action=edit&category=' . $category_id);
            } else {
                $error = "no change made";
            }
        } elseif ($submit == 'updatedescription') {
            $description = $_POST['description'];

            $success = updatedescription($description, $category_id);
            if ($success == 1) {
                header('Location: /?page=content&action=edit&category=' . $category_id);
            } else {
                $error = "no change made";
            }
        } elseif ($submit == 'updateparagraph') {
            $paragraph = $_POST['paragraph'];

            $success = updateparagraph($paragraph, $category_id);
            if ($success == 1) {
                header('Location: /?page=content&action=edit&category=' . $category_id);
            } else {
                $error = "no change made";
            }
        } elseif ($submit == 'updatepage') {
            $uniquename = $_POST['uniquename'];

            $success = updatepage($uniquename, $category_id);
            if ($success == 1) {
                header('Location: /?page=content&action=edit&category=' . $category_id);
            } else {
                $error = "no change made";
            }
        } elseif ($submit == 'deletepage') {


            $success = deletepage($category_id);
            if ($success == 1) {
                header('Location: /?page=content');
            } else {
                $error = "no change made";
            }
        }

        $result = getselectedcontent($category_id);
        $content .= '<h3> Update Content Page</h3>';
        $content .= '<form action =".?page=content&amp;action=edit&amp;category=' . $category_id . '" method="POST">
    title <input type="text" name="title" value="' . $result['title'] . '" required/> 
    <button type="submit" name="submit" value="updatetitle"> Update</button>
</form>    

<form action =".?page=content&amp;action=edit&amp;category=' . $category_id . '" method="POST">
     description <input type="text" name="description" value="' . $result['description'] . '" required/> 
         <button type="submit" name="submit" value="updatedescription"> Update</button>
         </form>
   
</form>
<form action =".?page=content&amp;action=edit&amp;category=' . $category_id . '" method="POST">
 paragraph <textarea name="paragraph" required >' . $result['paragraph'] . '</textarea> 
     <button type="submit" name="submit" value="updateparagraph"> Update</button>
     </form>
<form action =".?page=content&amp;action=edit&amp;category=' . $category_id . '" method="POST">
     uniquename <input type="text" name="uniquename" value="' . $result['page'] . '" required/> 
         <button type="submit" name="submit" value="updatepage"> Update</button>
         </form>
     

<form action =".?page=content&amp;action=edit&amp;category=' . $category_id . '" method="POST">
    <h3>delete Page</h3>
    <button type="submit" name="submit" value="deletepage"> Delete Page</button>
    
</form>
';
    }
} elseif ($page == 'images') {
    $title = 'image managment system';
    $content = buildimagelist($_SESSION['userid']);
    $categories = buildcategorydropdown();
    $content.= '<form action =".?page=images&amp;action=add" method="POST" enctype= "multipart/form-data">
    <h3>Add New Image</h3>
    File Upload <input type="file" name="file" id="file"/> <br> 
    description <input type="text" name="description"/><br> 
    Alt Text <input type="text" name="alttext" /><br> 
    choose category <select name= "categorydropdown"> 
    ' . $categories . '
        </select> <br>
     
    <button type="submit" name="submit" value="add"> Add</button>
    
</form>';
    if ($submit == 'add') {
        $alttext = htmlentities($_POST['alttext']);
        $description = $_POST['description'];
        $categorydropdown = $_POST['categorydropdown'];
        $userid = $_SESSION['userid'];
        $name = $_FILES['file']['name'];
        $type = $_FILES['file']['type'];
        $filename = fopen($_FILES['file']['tmp_name'], 'r');
        $image = fread($filename, filesize($_FILES['file']['tmp_name']));
        fclose($filename);

        $success = addimage($image, $description, $alttext, $categorydropdown, $name, $type, $userid);
        if ($success != FALSE) {
            header('Location: /?page=images');
        } else {
            $error = "no change made";
        }
    }

    if ($action == 'edit') {


        if ($submit == 'updateimage') {
            $alttext = htmlentities($_POST['alttext']);
            $description = $_POST['description'];
            $categorydropdown = $_POST['categorydropdown'];
           

            $success = updateimage($alttext, $description, $categorydropdown, $imageid );
            if ($success == 1) {
                header('Location: /?page=images&action=edit&imageid=' . $imageid);
            } else {
                $error = "no change made";
            }
        } elseif ($submit == 'deleteimage') {


            $success = deleteimage($imageid);
            if ($success == 1) {
                header('Location: /?page=images');
            } else {
                $error = "no change made";
            }
        }

        $result = getselectedimage($imageid);
        $content .= '<h3> Update Image </h3>';
        $content .= '<form action =".?page=images&amp;action=edit&amp;imageid=' . $imageid . '" method="POST">
        <img src = "data:' . $result['type'] . ';base64,' . base64_encode($result ['image']) . '"/><br>
    description <input type="text" name="description" value = "' . $result['description'] . '"/><br> 
    Alt Text <input type="text" name="alttext" value = "' . $result['alt'] . '"/><br> 
    choose category <select name= "categorydropdown"> 
    ' . $categories . '
        </select> <br>
        
    <button type="submit" name="submit" value="updateimage"> Update</button>
</form>         

<form action =".?page=images&amp;action=edit&amp;imageid=' . $imageid . '" method="POST">
    <h3>delete Image</h3>
    <button type="submit" name="submit" value="deleteimage"> Delete Image</button>
    
</form>
';
    }
} else {
    $result = getselectedcontent($category_id);
    $content = $result['paragraph'];
    
    $content .= getcategoryimages($category_id);
}


include 'views/view.php';

