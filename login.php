<?php
session_start();
include 'inc/db.php';
if (isset($_SESSION['logged_in'])) {
    header('location:admin.php');
}
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    if (empty($_POST['username']) or empty($_POST['password'])) {
        $error = 'all feild required !';
    } else {
        $qeury = $pdo->prepare("SELECT * FROM user WHERE user_name = ? AND user_psw = ? ");
        $qeury->bindValue(1, $username);
        $qeury->bindValue(2, $password);
        $qeury->execute();
        $num = $qeury->rowCount();
        if ($num == 1) {
            //user entered 
            $_SESSION['logged_in'] = true;
            header('location:admin.php');
            exit();
        } else {
            $error = 'Username OR Password is wrong!';
        }
    }
    
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php 
		      $query= $pdo->query("SELECT * FROM info ;");
			  while($row = $query->fetch(PDO::FETCH_ASSOC)){
			  echo strip_tags($row['name']);
			  }
		   ?>  Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="login-form">
    <form action="login.php" method="post">
        <h2 class="text-center">Log in</h2>       
        <div class="error" >
        <?php
            if (isset($error)) {
                echo $error;
            }
        ?>
</div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" required="required" name="username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" required="required" name="password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
           
    </form>
</div>
</body>
</html>                                		                            


