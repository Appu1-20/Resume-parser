
<!--  Add job -->

<div class="modal fade" id="addnewjobs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New Job</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="jobs_add.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="jtitle" class="col-sm-3 control-label">Job Title</label>

                    <div class="col-sm-9">
                      <input type="jtitle" class="form-control" id="jtitle" name="jtitle" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jdes" class="col-sm-3 control-label">Job Description</label>

                    <div class="col-sm-9">
                      <input type="jdes" class="form-control" id="jdes" name="jdes" required>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Job</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="jobs_edit.php">
                <input type="hidden" class="jid" name="jid" value="">
                <div class="form-group">
                    <label for="jtitle" class="col-sm-3 control-label">Job Title</label>

                    <div class="col-sm-9">
                      <input type="jtitle" class="form-control" id="jtitle" name="jtitle" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jdes" class="col-sm-3 control-label">Job Description</label>

                    <div class="col-sm-9">
                      <input type="jdes" class="form-control" id="jdes" name="jdes" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="category_delete.php">
                <input type="hidden" class="catid" name="jid">
                <div class="text-center">
                    <p>DELETE Job</p>
                    <h2 class="bold catname"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>
