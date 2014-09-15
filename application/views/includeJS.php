<script type="text/javascript" src="<?php echo base_url('assets/libs/jquery/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libs/jqueryui/jquery-ui.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libs/datatables/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libs/twitter-bootstrap/js/bootstrap.min.js');?>"></script>
<?php foreach ($js as $j) : ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/'.$j);?>"></script>
<?php endforeach; ?>