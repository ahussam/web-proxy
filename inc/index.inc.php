<?php 
if (basename(__FILE__) == basename($_SERVER['PHP_SELF']))
{
    exit(0);
}

echo '<?xml version="1.0" encoding="utf-8"?>';
include 'db.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
  <title>Web Proxy</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" title="Default Theme" media="all" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>
</head>
<body onload="document.getElementById('textbox').focus()">
<br>
<br>
<div id="container">
  <h1 id="title"><center>Surf <img src="img/mask.png" height="25px" widith="20px"></img> anonymous</center></h1>
 
<?php

switch ($data['category'])
{
    case 'auth':
?>
  <div id="auth"><p>
  <b>Enter your username and password for "<?php echo htmlspecialchars($data['realm']) ?>" on <?php echo $GLOBALS['_url_parts']['host'] ?></b>
  <form method="post" action="">
    <input type="hidden" name="<?php echo $GLOBALS['_config']['basic_auth_var_name'] ?>" value="<?php echo base64_encode($data['realm']) ?>" />
    <label>Username <input type="text" name="username" value="" /></label> <label>Password <input type="password" name="password" value="" /></label> <input type="submit" value="Login" />
  </form></p></div>
<?php
        break;
    case 'error':
        echo '<div id="error"><p>';
        
        switch ($data['group'])
        {
            case 'url':
                echo '<font color="#FFFFFF"<b>URL Error (' . $data['error'] . '):</b></font> ';
                switch ($data['type'])
                {
                    case 'internal':
                        $message = 'Failed to connect to the specified host. '
                                 . 'Possible problems are that the server was not found, the connection timed out, or the connection refused by the host. '
                                 . 'Try connecting again and check if the address is correct.';
                        break;
                    case 'external':
                        switch ($data['error'])
                        {
                            case 1:
                                $message = 'The URL you\'re attempting to access is blacklisted by this server. Please select another URL.';
                                break;
                            case 2:
                                $message = 'The URL you entered is malformed. Please check whether you entered the correct URL or not.';
                                break;
                        }
                        break;
                }
                break;
            case 'resource':
                echo '<b>Resource Error:</b> ';
                switch ($data['type'])
                {
                    case 'file_size':
                        $message = 'The file your are attempting to download is too large.<br />'
                                 . 'Maxiumum permissible file size is <b>' . number_format($GLOBALS['_config']['max_file_size']/1048576, 2) . ' MB</b><br />'
                                 . 'Requested file size is <b>' . number_format($GLOBALS['_content_length']/1048576, 2) . ' MB</b>';
                        break;
                    case 'hotlinking':
                        $message = 'It appears that you are trying to access a resource through this proxy from a remote Website.<br />'
                                 . 'For security reasons, please use the form below to do so.';
                        break;
                }
                break;
        }
        
        echo '<font color="#FF0000">There are some error with proxy !. <br />' . $message . ' </font></p>';
        break;
}
?>
<br>
<br>
  <form method="post" action="<?php echo  htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8"); ?>">
    <ul id="form">
      
	 <font id="box"><center><input id="textbox" autocomplete="off" type="text" name="<?php echo $GLOBALS['_config']['url_var_name'] ?>" value="<?php echo isset($GLOBALS['_url']) ? htmlspecialchars($GLOBALS['_url']) : '' ?>" onfocus="this.select()"  placeholder="http://anysite.com" /></font> <button type="button" class="btn btn-primary" type="submit">Brwose</button>
</li></center>
     <br /><center>
	 <div id="menu" style="display:none;">
	 <?php
      
      foreach ($GLOBALS['_flags'] as $flag_name => $flag_value)
      {
          if (!$GLOBALS['_frozen_flags'][$flag_name])
          {
              echo '<li class="option"><label><input type="checkbox" name="' . $GLOBALS['_config']['flags_var_name'] . '[' . $flag_name . ']"' . ($flag_value ? ' checked="checked"' : '') . ' />' . $GLOBALS['_labels'][$flag_name][1] . '</label></li>' . "\n";
          }
      }
      ?>
    </ul>
	<center><input type="checkbox" onclick="toggle_visibility('menu');"/><font color="#FFFFFF"> Advanced Options</font>&nbsp;<input type="checkbox" onclick="toggle_visibility('ip');"/><font color="#FFFFFF"> Your IP<div id="ip" style="display:none;"><font color="#25A6E1"><?php echo $_SERVER['REMOTE_ADDR']; ?></font></div></center></div>
  </form>
 
  
  </center>
<div id="footer">        
  <hr>
<p align="right">

      Design by <a href="https://github.com/ahussam" ><font color="#FFFF00" style="normal">Abdullah Hussam</font></a>&nbsp;&nbsp;&nbsp;
	  
	  </p>
	  <p align="right">
 <a href="<?php
$query= $pdo->query('SELECT * FROM info ;');
while($row= $query->fetch(PDO::FETCH_ASSOC)){
echo $row['facebook'];
}
?>"
 target="_blank"><img src="img/facebook.png" height="40"></a>
 <a href="<?php
 $query= $pdo->query('SELECT * FROM info ;');
 while($row = $query->fetch(PDO::FETCH_ASSOC)){
 echo htmlspecialchars($row['twitter']);
 }
 ?>
 " target="_blank"><img src="img/twitter.png" height="40"></a>
 <a href="mailto:<?php
 $query= $pdo->query('SELECT * FROM info ;');
 while($row = $query->fetch(PDO::FETCH_ASSOC)){
 echo htmlspecialchars($row['email']);
 }
 ?>" target="_blank"><img src="img/report.png" height="40"></a>&nbsp;&nbsp;&nbsp;

           <center> <?php 
		      $query= $pdo->query("SELECT * FROM info ;");
			  while($row = $query->fetch(PDO::FETCH_ASSOC)){
			  echo strip_tags($row['name']);
			  }
		   ?></center>
		
</p>
  </div>
</body>
</html>