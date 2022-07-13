<?php

  require 'database.php';
  $q = $_GET['q'];
  $conn = getConnection();
  echo getProdQuant($conn, $q);

 ?>
