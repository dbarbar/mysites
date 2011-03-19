<?php
/*
*  Web-enabled greeting system prototype for XYZ Corporation
*  By David Barbarisi
*  index.php
*  Determines actions to take based on $_REQUEST['action']
*  action can be:  login, createnewaccount, modifyaccount, logout, modifyaccountform, newaccountform
*/

require_once('functions.php');

session_start();

$title = '';
$output = '';
$error = '';

if (isset($_REQUEST['action'])) {
  switch ($_REQUEST['action']) {

    // login form has been filled out
    case 'login':
      // authenticate user, then generate error or successfully log in
      $error = authenticateuser($_POST['username'], $_POST['password']);
      
      if ($error != '') {
        $title = 'Log in';
        $output = '<div class="error">' .$error. '</div>' . displayloginform();;
      } else {
        $title = 'Greetings';
        $output = '<div class="info">You are now logged in</div>' . displaygreeting();
      }
    break;

    // new account form has been filled out
    case 'createnewaccount':
      // determine if required fields were filled out and valid
      $error = validateaccountform();
      
      if ($error != '') {
        $title = 'Create a new account at XYZ Corporation';
        $output = '<div class="error"><p><strong>The following items need to be corrected:</strong</p><ul>' .$error. '</ul></div>' . displayaccountform();
      } else {
      
      // add user record to file
      addrecord();
      
      // set session data so user is logged in
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['firstname'] = $_POST['firstname'];
      $_SESSION['lastname'] = $_POST['lastname'];
      
      $title = 'Greetings';
      $output = '<div class="info">You are now logged in</div>' . displaygreeting();
    }
    break;
    
    // account modification form has been filled out
    case 'modifyaccount':
    // make sure form data is still valid
    // false is passed so that username check is bypassed and the password check is bypassed if the user didn't enter a new one
      $error = validateaccountform(false);
      
      if ($error != '') {
        $title = 'Modify Account';
        $output = '<div class="error"><p><strong>The following items need to be corrected:</strong</p><ul>' .$error. '</ul></div>' . displayaccountform(false);
      } else {
      // find username in file and replace it with new data
      if(replaceuserdata()) {
        $output = '<div class="info">Your account has been updated.</div>';
      } else {
        $output = '<div class="error">There was an error updating your account.</div>';
      }
      // take the user back to the modify account page, regardless of success or failure
      $title = 'Modify Account';
      $output = $output . displayaccountform(false);
    }
    break;
    
    // logging out and sending the user back to the login form on the home page
    case 'logout':
      // clear out the session
      $_SESSION = array();
      session_destroy();
      $title = 'Welcome to XYZ Corporation';
      $output = '<div class="info">You have successfully logged out.</div>' . displayloginform();
    break;
    
    // creates the account modification form page
    case 'modifyaccountform':
    // user should only see this page if logged in
    if (isset($_SESSION['username'])) {
      $title = 'Modify Account';
      $output = displayaccountform(false);
    } else {
      // not logged in
      $title = 'Welcome to XYZ Corporation';
      $output = displayaloginform();
    }
    break;
    
    // creates the account creation form page
    case 'newaccountform':
      $title = 'Create a new account at XYZ Corporation';
      $output = displayaccountform();
    break;

    // action is set, but not to anything valid, so display greeting page if logged in, login form otherwise
    default:
    if (isset($_SESSION['username'])) {
      $title = 'Greetings';
      $output = displaygreeting();
    } else {
      $title = 'Welcome to XYZ Corporation';
      $output = displayloginform();
    }
    break;
  }
} else {
  // no get, post, or cookie variables named action set, so display greeting if logged in, or login form if not
  if (isset($_SESSION['username'])) {
    $title = 'Greetings';
    $output = displaygreeting();
  } else {
    $title = 'Welcome to XYZ Corporation';
    $output = displayloginform();
  }
}

// create the page and display it
generatepage($title, $output);

?>