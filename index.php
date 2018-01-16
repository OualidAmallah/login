<?php
if (isset($_POST['usuarios'])) {
    $usuarios = $_POST['usuarios'];
}

if (isset($_POST['username'])) {
    $usuarios[htmlspecialchars($_POST['username'])] = htmlspecialchars($_POST['password']);
}

if (isset($_POST['login'])) {
    $loginCorrecto = $usuarios[$_POST['login']] === htmlspecialchars($_POST['password']);
}

?>


<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Flat HTML5/CSS3 Login Form</title>
      <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php if(isset($loginCorrecto)) : ?>
    <?php if($loginCorrecto) : ?>
            <p>Login correcto
        <?php else :?>
            <p>Login incorrectoincorrecto
    <?php endif; ?>
<?php endif; ?> 
  <div class="login-page">
  <div class="form">
    <form class="register-form" action="" method="post">
      <input type="text" placeholder="name" name="username"/>
      <input type="password" placeholder="password" name="password"/>
      <?php
                if(isset($usuarios)) :
                    foreach ($usuarios as $username => $password) :
            ?>
                <input type="hidden" name="usuarios[<?php echo $username ?>]" value="<?php echo $password ?>"/>
            <?php
                    endforeach;
                endif;
            ?>
            <input id="boton" type="submit" value="registrar"/>
    </form>


    <form class="login-form" method="post">
      <input type="text" placeholder="username" name="login" />
      <input type="password" placeholder="password" name="password"/>
      <?php
            if(isset($usuarios)) :
                foreach ($usuarios as $username => $password) :
                    ?>
                    <input type="hidden" name="usuarios[<?php echo $username ?>]" value="<?php echo $password ?>"/>
                <?php
                endforeach;
            endif;
            ?>
            <input type="submit" id="boton" value="login"/>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script  src="js/index.js"></script>

    <?php
    
    ?>
</body>

</html>
