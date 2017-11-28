<?php
require_once('config.inc.php');
require('php/phpbitadmin.class.php');
include('php/init_ui_vars.php'); 
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bitcoin Node</title>
<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css" />
<link rel="stylesheet" href="css/m_phpbitadmin.css" />
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<!-- <script type="text/javascript">
    $(document).bind("pagecreate", function () {
					    $.mobile.ajaxEnabled = false;
						});
</script> -->

<style>
input.normal {
     width: 45px !important;
    display: inline-block; }
</style>

</head>
<body>

<!-------------------------------------------------
HOME Page
---------------------------------------------------->
<div data-role="page" id="home" data-theme="a">
    <?php include "html/menu_home.html"; ?>
    <?php include "html/header_home.html"; ?>
    <?php include "html/home_page.php"; ?>
</div>

<!-------------------------------------------------
About Page
---------------------------------------------------->
<div data-role="page" id="about" data-theme="a">
    <?php include "html/menu_about.html"; ?>
    <?php include "html/header_about.html"; ?>
    <?php include "html/about_page.php"; ?>
</div> 

</body>
</html>

