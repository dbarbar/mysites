<?php
/*
*  Web-enabled greeting system prototype for XYZ Corporation
*  By David Barbarisi
*  functions.php
*  Contains form validation, file and session operations, and presentation functions
*/

/*
*  validateaccountform
*  checks post variables to make sure username, first name, and last name aren't blank
*  and that password fields match and password is > 6 characters
*  uses post variables as input
*  returns zero or more errors as a string
*/
function validateaccountform($newaccount = true) {
  $error = '';
  if($newaccount) {
    if ($_POST['username'] == '') {
      $error .= '<li>Please enter a username.</li>';
    } elseif (searchusernames($_POST['username'])) {
      $error .= '<li>That username already exists. Please choose a different one.</li>';
    }
  }
  if ($_POST['password'] != $_POST['passwordverify']) {
    $error .= '<li>The passwords you entered do not match.</li>';
  }
  if (strlen($_POST['password']) < 6) {
    if ($newaccount) {
      $error .= '<li>Please enter a password at least 6 characters long.</li>';
    } else {
      if (strlen($_POST['password']) != 0) {
        $error .= '<li>Please enter a password at least 6 characters long.</li>';
      }
    }
  }
  if ($_POST['firstname'] == '') {
    $error .= '<li>Please enter your first name.</li>';
  }
  if ($_POST['lastname'] == '') {
    $error .= '<li>Please enter your last name.</li>';
  }
  return $error;
}

/********** File functions **********/

/*
*  addrecord
*  appends a new user record to users.txt
*  uses post variables as input
*  writes to users.txt
*/
function addrecord() {
  $usersfile = fopen('users.txt', 'ab');
  flock($usersfile, LOCK_EX);
  $userrecord = $_POST['username'] . ',' . $_POST['password'] . ',' . $_POST['firstname'] . ',' . $_POST['lastname']. "\n";
  fwrite($usersfile, $userrecord);
  flock($usersfile, LOCK_UN);
  fclose($usersfile);
}

/*
*  authenticateuser
*  searches the flat file for the username and password combination
*  username and password as input
*  returns an error string or an empty string for no error
*/
function authenticateuser($username, $password) {
  $error='';
  $usersfile = fopen('users.txt', 'r');
  flock($usersfile, LOCK_SH);
  $found = false;
  while ( ($user = fgetcsv($usersfile, 1000, ',')) !== false) {
    if($user[0] == $username && $user[1] == $password) {
      $_SESSION['username'] = $user[0];
      $_SESSION['firstname'] = $user[2];
      $_SESSION['lastname'] = $user[3];
      $found = true;
      break;
    }
  }
  if(!$found) {
    $error = 'The username or password is incorrect.';
  }
  flock($usersfile, LOCK_UN);
  fclose($usersfile);
  return $error;
}

/*
*  replaceuserdata
*  rewrites users.txt with modified user data and sets new session first and last names
*  uses session and post variables and users.txt for input
*  outputs new users.txt file and modifies session
*/
function replaceuserdata() {
  $usersfile = fopen('users.txt', 'r');
  flock($usersfile, LOCK_EX);
  $users = array();
  $updated = false;
  
  while ( ($user = fgetcsv($usersfile, 1000, ',')) !== false) {
    if($user[0] == $_SESSION['username']) {
      // if the user changed the password, then use the new one, otherwise keep the old password from the file
      if (isset($_POST['password']) && $_POST['password'] != '') {
        $user[1] = $_POST['password'];
      }
      $user[2] = $_POST['firstname'];
      $user[3] = $_POST['lastname'];
      
      $_SESSION['firstname'] = $_POST['firstname'];
      $_SESSION['lastname'] = $_POST['lastname'];
      $updated = true;
    }
    $users[] = implode(',', $user);
  }
  flock($usersfile, LOCK_UN);
  fclose($usersfile);
  
  $usersfile = fopen('users.txt', 'wb');
  flock($usersfile, LOCK_EX);
  
  foreach ($users as $user) {
    fwrite($usersfile, $user . "\n");
  }
  flock($usersfile, LOCK_UN);
  fclose($usersfile);
  
  return $updated;
}

/*
*  searchusernames
*  searches flat file for username
*  username as input
*  returns true if the username exists, false otherwise
*/
function searchusernames($username) {
  $usersfile = fopen('users.txt', 'r');
  flock($usersfile, LOCK_SH);
  $found = false;
  while ( ($user = fgetcsv($usersfile, 1000, ',')) !== false) {
    if($user[0] == $username) {
      $found = true;
      break;
    }
  }
  flock($usersfile, LOCK_UN);
  fclose($usersfile);
  return $found;
}

/********** Presentation functions **********/

/*
*  displayaccountform
*  constructs the html for the account creation/modification form
*  accepts an optional newaccount variable that should be set to true if this is a new user, false otherwise
*  defaults to true
*  returns html output string
*/
function displayaccountform($newaccount = true) {
  if ($newaccount) {
    $usernamevalue = isset($_POST['username']) ? $_POST['username'] : '';
    $firstnamevalue = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastnamevalue = isset($_POST['lastname']) ? $_POST['lastname'] : '';
  } else {
    $usernamevalue = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $firstnamevalue = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
    $lastnamevalue = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';
  }
  $output = '<form action="' .$_SERVER['PHP_SELF']. '" method="post"><fieldset><legend>';
  $output .= $newaccount ? 'Create a new account' : 'Edit your account';
  $output .= '</legend>';
  $output .= '<label>Username:  <input type="text" size="32" maxlength="32" name="username" id="username" value="';
  $output .= htmlspecialchars($usernamevalue);
  $output .= '"';
  $output .= $newaccount ? '' : ' disabled="disabled"';
  $output .=  ' /></label>';
  $output .= '<label>Password:  <input type="password" size="32" maxlength="32" name="password" id="password" value="" /></label>';
  $output .= '<label>Enter password again: <input type="password" size="32" maxlength="32" name="passwordverify" id="passwordverify" value="" /></label>';
  $output .='<label>First Name:  <input type="text" size="32" maxlength="32" name="firstname" id="firstname" value="';
  $output .= htmlspecialchars($firstnamevalue);
  $output .= '" /></label>';
  $output .='<label>Last Name:  <input type="text" size="32" maxlength="32" name="lastname" id="lastname" value="';
  $output .= htmlspecialchars($lastnamevalue);
  $output .= '" /></label>';
  $output .= '<input type="hidden" name="action" id="action" value="';
  $output .= $newaccount ? 'createnewaccount' : 'modifyaccount';
  $output .= '" /><input type="submit" name="submitaccountform" id="submitaccountform" value="';
  $output .= $newaccount ? 'Create New Account' : 'Modify Details';
  $output .= '" />';
  $output .= '</fieldset></form>';
  $output .= '<br /><p><a href="' .$_SERVER['PHP_SELF']. '">Back to the home page</a></p>';
  return $output;
}

/*
*  displaygreeting
*  Constructs the html for the greeting page
*  returns html string
*/
function displaygreeting() {
  $output = '<p>Hello '. $_SESSION['firstname'] .' '. $_SESSION['lastname'] .'! Welcome to XYZ Corporation.</p>';
  $output .= '<br /><p><a href="' .$_SERVER['PHP_SELF']. '?action=modifyaccountform">Modify my account.</a></p>';
  $output .= '<p><a href="' .$_SERVER['PHP_SELF']. '?action=logout">Log out.</a></p>';
  return $output;
}

/*
*  displayloginform
*  Constructs the html for displaying the login form
*  returns an output string
*/
function displayloginform() {
  $output = '<form action="' .$_SERVER['PHP_SELF']. '" method="post"><fieldset><legend>Log in to XYZ Corporation</legend>';
  $output .= '<label>Username: <input type="text" size="32" maxlength="32" name="username" id="username" value="" /></label>';
  $output .= '<label>Password:  <input type="password" size="32" maxlength="32" name="password" id="password" value="" /></label>';
  $output .= '<input type="hidden" name="action" id="action" value="login" />';
  $output .= '<input type="submit" name="login" id="login" value="Log in" />';
  $output .= '</fieldset></form';
  $output .= '<br /><p><a href="' .$_SERVER['PHP_SELF']. '?action=newaccountform">Create a new account</a></p>';
  return $output;
}

/*
*  generatepage
*  outputs the full html page to the browser
*  takes a title string and output html string for the page body
*/
function generatepage($title='', $output) {
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html>
  <head>
  <title><?php echo $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="styles.css" />
  </head>
  <body>
  <div id="content">
  <h1><?php echo $title; ?></h1>
  <?php echo $output; ?>
  </div>
  </body>
  </html>
  <?php
}

?>