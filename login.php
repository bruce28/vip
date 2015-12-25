<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="content-type" content="text/html;charset=iso-8859-2">
<title></title>
<style>
#ramka {width:252; height:97; background-color:red}
#login {width:250; height:95; background-color:lightblue}
</style>

 <link href="/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="lo.css" rel="stylesheet">


</head>
<body topmargin=1>
<hr>
<BR />
<BR />
<BR />
<BR />
<?php include 'header_login.php'?>
  <div class="container">
  <form class="form-signin" name="log" method="post" action="log_pro.php">
        <h2 class="form-signin-heading">GRR DATABASE 2 SYSTEM.</h2>
        <input type="text" name="login" class="form-control" placeholder="GRR Member" autofocus>
        <input type="password" name="pass" class="form-control" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
      </form>

    <!-- /container -->




 </div>
</body>
</html> 