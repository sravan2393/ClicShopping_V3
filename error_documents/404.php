<?php
/**
 *
 * @copyright 2008 - https://www.clicshopping.org
 * @Brand : ClicShopping(Tm) at Inpi all right Reserved
 * @Licence GPL 2 & MIT
 * @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\HTTP;
  use ClicShopping\OM\CLICSHOPPING;

  http_response_code(404);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>404 - Error - Page Not Found</title>
  <meta name="description" content="404">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <?php echo '<link rel="stylesheet" href="' . CLICSHOPPING::link('error_documents/css/base.css')  . '" media="screen, print">'; ?>
  <?php echo '<link rel="stylesheet" href="' . CLICSHOPPING::link('error_documents/css/main.css')  . '" media="screen, print">'; ?>
  <link rel="shortcut icon" href="../images/favicon.png">
</head>
<body>

<div id="content-wrap">
  <main class="row">
    <div id="main-content" class="twelve columns">
      <br/>
      <h1>404 Error - Page Not Found</h1>
      <p>We're looking what's happen.</p>
      <p><a href="../index.php">Click here to come back to index page</a></p>
      <br/><br/>
      <hr>
    </div>
  </main>

</div>
<div id="preloader">
  <div id="loader"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.0/jquery-migrate.min.js"></script>
<?php echo '<script src="' . CLICSHOPPING::link('error_documents/js/main.js')  . '"></script>'; ?>
</body>
</html>
