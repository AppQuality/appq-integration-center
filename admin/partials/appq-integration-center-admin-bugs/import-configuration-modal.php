
<!-- Modal -->
<div class="modal" style="z-index: 99999;" id="import_from_cp_modal" tabindex="-1" role="dialog" aria-labelledby="import_from_cp_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div style="z-index: 99999;" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="import_from_cp_modalLabel">Import configuration from campaign</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form mt-2">
		  <form id="import_from_cp">
	          <div class="form-group row m-2 mb-2">
	            <label for="source_id" style="position: absolute;top:0 ;font-size: 12px; opacity: 0.5; margin-bottom: 0;">Campaign id</label>
	            <input class="form-control col-10" type="text" name="source_id" placeholder="1234" />
	            <button type="submit" class="col-2 btn btn-primary">Import</button>
	          </div>
		  </form>
      </div>
    </div>
  </div>
</div>
