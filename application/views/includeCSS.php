<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libs/normalize/normalize.min.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libs/jqueryui/css/jquery-ui.min.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libs/datatables/css/jquery.dataTables.min.css'); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/libs/twitter-bootstrap/css/bootstrap.min.css'); ?>">
<?php foreach ($css as $c) : ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/'.$c); ?>">
<?php endforeach; ?>