<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A complete and most powerful school system management system for all. Purchase and enjoy">
    <meta name="author" content="OPTIMUM LINKUP COMPUTERS">
		<?php 
		//////////LOADING SYSTEM SETTINGS FOR ALL PAGES AND ACCOUNTS/////////
		$system_title	=	get_school_name();
		?>

    <link rel="icon"  sizes="16x16" href="<?php echo get_school_logo(); ?>">
    <title><?php echo $page_title;?>&nbsp;|&nbsp;<?php echo $system_title;?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>optimum/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" >

    <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet" >
    <!-- Menu CSS -->
    <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet" >
    <!-- morris CSS -->
    <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/morrisjs/morris.css" rel="stylesheet" >
    <!-- animation CSS -->
    <link href="<?php echo base_url(); ?>optimum/css/animate.css" rel="stylesheet" >
    <!-- Custom CSS -->
<?php if ($text_align == 'right-to-left') { ?>
  <link href="<?php echo base_url(); ?>optimum/css/style-rtl.css" rel="stylesheet" >
<?php } else { ?>
  <link href="<?php echo base_url(); ?>optimum/css/style.css" rel="stylesheet" >
<?php } ?>
