<div class="container">
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 text-center">
            <div class="col-xs-4">
                <a class="btn btn-primary" href="<?php echo isset($backMonth)?base_url('site/month/'.$backMonth):'#' ?>">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            </div>
            <div class="col-xs-4"><?php echo isset($month)?$month:'' ?></div>
            <div class="col-xs-4">
                <a class="btn btn-primary" href="<?php echo isset($forMonth)?base_url('site/month/'.$forMonth):'#' ?>">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="feedback" class="alert">
        </div>
    </div>
    <div class="row" id="insertPoint">
        <div class="col-sm-12">
            <form class="form-inline" method="post" id="form-month-dateTime">
                <div class="form-group">
                    <label for="date" class="control-label">Data</label>
                    <input id="date" type="date" name="date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="time" class="control-label">Horário</label>
                    <input id="time" type="time" name="time" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        Inserir
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div id="points-month" class="table-responsive">
                <?php $this->load->view('site/month-pointTable'); ?>
            </div>
        </div>
    </div>
</div>