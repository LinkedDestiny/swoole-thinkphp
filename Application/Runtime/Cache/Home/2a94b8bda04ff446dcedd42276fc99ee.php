<?php if (!defined('THINK_PATH')) exit();?><html>
<body>

<?php  echo ( $SERVER['PATH_INFO'] ); ?>
<p>Hello <?php echo $name?></p>
<form action="_PHP_FILE_?s=/Home/Index/form" method="post">
  <p>First name: <input type="text" name="fname" id="fname" /></p>
  <p>Last name: <input type="text" name="lname" id="lname" /></p>
  <input type="submit" value="Submit" />
</form>

<p>请单击确认按钮</p>
<a href="_PHP_FILE_?s=/Home/Form/index/name/hello">click</a>
</body>
</html>