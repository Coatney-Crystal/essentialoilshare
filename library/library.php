<?php

function builduserslist() {

    $result = GetAllUsers();
    if ($result) {


        $userlist = '<ul>';

        foreach ($result as $user) {
            $userlist .= '<li>' . $user['email'] . ' <a href= "?page=client&amp;user=' . $user['user_id'] . '&amp;action=edit">edit</a>';
        }
        $userlist .= '</ul>';
        return $userlist;
    } else {
        return 'no client to list';
    }
}

function buildcontentlist() {

    $result = GetAllContent();
    if ($result) {
        $contentlist = '<ul>';

        foreach ($result as $content) {
            $contentlist .= '<li>' . $content['title'] . ' <a href= "?page=content&amp;category=' . $content['category_id'] . '&amp;action=edit">edit</a></li>';
        }
        $contentlist .= '</ul>';
        return $contentlist;
    } else {
        return 'no content to list';
}
}
function buildnavigation() {

    $result = GetNavigation();
    if ($result) {
        $nav = '';

        foreach ($result as $link) {
            $nav .= ' <a href= "'.$link[1] .'&amp;category='.$link[2] .' ">'.$link[0] .'</a> ';
        }
       
        return $nav;
    } else {
        return 'no navigation';
}
}


function buildimagelist($userid)  {

    $result = GetUsersImages($userid);
    if ($result) {
        $imagelist = '<ul>';
        
        foreach ($result as $content) {
            $imagelist .= '<li>' . $content['alt'] . ' <a href= "?page=images&amp;imageid=' . $content['imageid'] . '&amp;action=edit">edit</a> </li>';
        }
        $imagelist .= '</ul>';
        return $imagelist;
    } else {
        return 'no images to list';
}
}
function buildcategorydropdown() {

    $result = GetAllContent();
    if ($result) {
        $contentlist = '';

        foreach ($result as $content) {
            $contentlist .= '<option name = "categorydropdown" value= '.$content['category_id'].'>' . $content['title'] . '</option>';
        }
        
        return $contentlist;
    } else {
        return 'no content to list';
    }
function getcategoryimages($categoryid)  {

    $result = GetImages($categoryid);
    if ($result) {
        $imagelist = '<table>';
        $image=0;
        for ($r=0;$r<sizeof($result)/3;$r++) {
            $imagelist.='<tr>';
            for ($c=0;$c<3;$c++) {
                
            $imagelist .= '<td>  <img src = "data:' . $result[$image]['type'] .
            ';base64,' . base64_encode($result [$image] ['image']) . 
            '" alt= "'.$result [$image] ['alt'].'"/><br><p class = "description">'.$result [$image] ['description'].' </p></td>';
            $image++;
        }
        $imagelist .= '</tr>';
        }
        $imagelist .= '</table>';
        return $imagelist;
    } else {
        return 'no images to list';
}
} 
//Called from add_person() and login() in the accountmodel
function hashPassword($pword) {
  //hash pass using blowfish.
  $pword2 = crypt($pword, '$2y$07$uses0m3s1llystringfOrs@lt$');
  return $pword2;
}

//Filtering functions!
function filterName($input) {
  //Verify name 
  if (preg_match('#[0-9]#', $input)) {
    return false;
  } else {
    $input = remove_tags($input);

    return $input;
  }
}

function validateEmail($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return FALSE;
  } else {
    return TRUE;
  }
}

function remove_tags($input) {
  //This function removes all html tags from input
  $input = filter_var($input, FILTER_SANITIZE_STRING);
  return $input;
}

function nonExecutable_tags($input) {
  //This will make it so tags can be stored, but they are no longer executable. They show only as special characters.
  $input = filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS);
  return $input;
}
         
}        