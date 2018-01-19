<?php
$dbname="usuarios";
$user="root";
$password="alumno";
try {
    $dsn = "mysql:host=localhost;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e){
    echo $e->getMessage();
}


if (isset($_POST['usuarios'])) {
    $usuarios = $_POST['usuarios'];
}

if (isset($_POST['username'])) {
    $usuarios[htmlspecialchars($_POST['username'])] = htmlspecialchars($_POST['password']);

// Prepare
    $stmt = $dbh->prepare("INSERT INTO usuarios (user, pass) VALUES (:user, :pass)");
    
// Bind
    $nombre=htmlspecialchars($_POST['username']);
    $password=htmlspecialchars($_POST['password']);
    $stmt->bindParam(':user', $nombre);
    $stmt->bindParam(':pass', $password);
// Excecute
    $stmt->execute(); 

    }

if (isset($_POST['login'])) {

// Prepare
    $stmt = $dbh->prepare("SELECT * FROM usuarios WHERE user = ? AND pass = ?");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
// Bind
    $nombre = htmlspecialchars($_POST['login']);
    $password=htmlspecialchars($_POST['password']);

    $stmt->bindParam(1, $nombre);
    $stmt->bindParam(2, $password);
// Excecute
    $stmt->execute();
//mostrar resultado
    if ($row = $stmt->fetch()){
        echo "Usted ha autenticado con seguiente parametros: <br>";
        echo "Nombre: {$row["user"]} <br>";
        echo "Ciudad: {$row["pass"]} <br><br>";
    } else{
        echo "Algo falla en el Login";
    } 
   // $loginCorrecto = $usuarios[$_POST['login']] === htmlspecialchars($_POST['password']);
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
                <?php
                // FETCH_ASSOC
                    $stmt = $dbh->prepare("SELECT * FROM usuarios");
                // Especificamos el fetch mode antes de llamar a fetch()
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                // Ejecutamos
                    $stmt->execute();
                // Mostramos los resultados
                    while ($row = $stmt->fetch()){
                     echo "usuario: {$row["user"]} <br>";
                    echo "password: {$row["pass"]} <br><br>";
                }

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
