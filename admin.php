<?php
session_start();

include 'inc/db.php';


if (isset($_SESSION['logged_in'])) {
    
    
    if (isset($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])){
        if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['HTTP_HOST'])
			exit('Anti-CSRF mechanism!');
	}
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (empty($username) OR empty($password)) {
            $error = '<div class="error" > You left user OR password blank!</div>';
        } else {

            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $query    = $pdo->prepare("UPDATE user SET user_name= ?, user_psw= ? WHERE user_id = '1' ");
            
            $query->bindValue(1, $username);
            $query->bindValue(2, $password);
            $query->execute();

            $facebook = $_POST['facebook'];
            $twitter  = $_POST['twitter'];
            $email    = $_POST['email'];
            $sitename = $_POST['name'];
            $query    = $pdo->prepare("UPDATE info SET name = ? ,facebook= ?, twitter= ?, email= ?  WHERE id = '1' ");

            $query->bindValue(1, $sitename);
            $query->bindValue(2, $facebook);
            $query->bindValue(3, $twitter);
            $query->bindValue(4, $email);
            $query->execute();
            header('location:admin.php');
        }
    }
?>
<html>
<head><title>Control panel</title>
<link rel="stylesheet" type="text/css" href="css/admin.css" />
</head>
<body>
<center>
</br>
</br></br>
<table bgcolor="#25A6E1">
<tr>
<td width="750px">
<center>
<h2><font color="">Control panle -<a href="logout.php">Log out</a></font></h2>
<hr>
<div class="form">
<form action="admin.php" method="POST" >

Change admin info :
</br>

<?php
    if (isset($error)) {
        echo $error;
    }
?>
</br>
Admin id :<input type="text" name="username" value="<?php
    $query = $pdo->query('SELECT * FROM user ;');
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['user_name']);
    }
?>" />
</br>
Password :<input type="password" name="password" />
</br>
<hr>
Change proxy site info :
</br>
</br>
Site name:<input type="text" name="name" value="<?php
    $query = $pdo->query("SELECT * FROM info ;");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['name']);
    }
?>"/>
</br>
</br>
Facebook:<input type="text" name="facebook" value="<?php
    $query = $pdo->query("SELECT * FROM info ;");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['facebook']);
    }
?>"/>
		   </br>
		   </br>
Twitter :<input type="text" name="twitter" value="<?php
    $query = $pdo->query("SELECT * FROM info ;");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['twitter']);
    }
?>" />
		   </br>
		   </br>
support :<input type="text" name="email" value="<?php
    $query = $pdo->query("SELECT * FROM info ;");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['email']);
    }
?>"/>
		   </br>
		   </br>
<input type="submit" name="submit" value="Change"/>
</form>
</td>
</tr>
</div>
</table>
</center>
</body>
</html>
<?php
} else {
    echo 'error';
}
?>