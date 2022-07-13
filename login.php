<?php require "database.php";
  session_start();
  $conn = getConnection();

  if ( !empty($_POST['email'] and !empty($_POST['password'])) ) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = getUser($conn, $email, $password);
    if ( isset($user) ) {
      $_SESSION['role'] = $user['role'];
      $_SESSION['name'] = $user['first_name'];
      if ( $user['role'] == 1 ) {
        header("Location: order_entry.php?a=" . $_SESSION['name']);
      } else if ( $user['role'] == 2 ) {
        header("Location: adminProduct.php");
      } else {
        header("Location: store.php");
      }

    } else {
      header("Location: index.php?err=Invalid User Information");
    }
  } else {
    header("Location: index.php?err=Please enter your email and password");
  }
?>
