<div class="container">
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