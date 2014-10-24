<div class="container">
    <div class="row">
        <div id="feedback" class="alert">
        </div>
    </div>
    <div class="row" id="csv-import">
        <div class="col-sm-12">
            <form class="form-inline" id="form-csv-import" action="<?php echo base_url("reader/import"); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userfile" class="control-label">xlsx file: </label>
                    <input type="file" name="userfile" id="userfile" class="form-control">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Import">
                     
                </div>
            </form>
        </div>
    </div>
</div>