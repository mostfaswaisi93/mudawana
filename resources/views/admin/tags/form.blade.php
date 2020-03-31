<!-- Tag Modal -->

<div class="modal fade" id="tagModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="tagForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label col-md-2">{{ trans('admin.name') }}: </label>
                        <div class="col-md-9">
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="{{ trans('admin.e_name') }}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <button type="submit" class="btn btn-primary" id="action_button" name="action_button"
                            value="Add"><i class="fa fa-save"></i>
                            {{ trans('admin.save_changes') }}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            {{ trans('admin.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete -->

<div class="modal fade" id="confirmModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <h4 style="margin: 0;" class="text-center">{{ trans('admin.are_you_sure_tag') }}
                </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    {{ trans('admin.delete') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                    {{ trans('admin.close') }}</button>
            </div>
        </div>
    </div>
</div>