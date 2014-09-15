<div class="container">
    <div class="row">
        <div class="col-sm-6 text-center" id="time">
            <span class="form-group hour"></span>
            <span class="form-group">:</span>
            <span class="form-group min"></span>
            <span class="form-group">:</span>
            <span class="form-group sec"></span>
        </div>
        <div class="col-sm-6 text-center" id="date">
            <span></span>
        </div>
    </div>
    <div class="row">
        <div id="feedback" class="alert">
        </div>
    </div>
    <div class="row" id="insertPoint">
        <div class="col-sm-offset-0">
            <form class="form-inline" id="form-dateTime" method="post">
                <input type="hidden" name="date">
                <div class="form-group">
                    <label class="control-label">Horário</label>
                    <input name="time" class="form-control" type="time"  value="">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">
                        Inserir
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive" id="points">
            <?php $this->load->view('site/index-pointTable'); ?>
        </div>
    </div>
</div>
<script>
    var curDateTime = '<?php echo $curDateTime;?>';
</script>