<!DOCTYPE HTML>
<html>
<!-- header.html - include file containing contents for <head> section and page header -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $page_title; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/form.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no" />
</head>

<body>
<div id="wrapper">
	<div id="header">
		<h1><?php echo $header_title; ?></h1>
		<h2><?php echo $header_subtitle; ?></h2>
	</div>
	
	<div id="content">
	
<?php   //  Show system messages; useful for info or for debugging
	if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
		echo "<p>" . $_SESSION['message'] . "</p>";
		unset ($_SESSION['message']);
	}
?>
<!-- End of header.html -->
