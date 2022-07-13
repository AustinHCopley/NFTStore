
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="author" content="Austin Copley">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <?php
    require 'header.php';
    require 'database.php';
    date_default_timezone_set("America/Denver");
    $conn = getConnection();
    $products = getProducts($conn);
    ?>
    <article>
      <p>Welcome! Please log in or continue as a guest. <?php if (isset($_GET["err"])) { echo "<span id='error'><strong>" . $_GET["err"] . "</strong></span>";}?></p>
      <form method="post" action="login.php">
        <fieldset>
          <p>Email</p>
          <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="characters@characters.domain" required>
          <p>Password</p>
          <input type="password" name="password" title="Your password" required><br>
          <input id="submit" type="submit" value="Login">
        </fieldset>
      </form>
      <a href='store.php'><button><em>Continue as Guest</em></button></a>
    </article>
  </body>
  <?php require 'footer.php'; ?>
</html>
