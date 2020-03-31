@extends('layouts.index')

@section('content')

<div class="page-content-wrapper">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">{{ trans('admin.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/tags">{{ trans('admin.tags') }}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-tags font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{ trans('admin.tags') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button name="create_tag" id="create_tag"
                                        class="btn green">{{ trans('admin.add_new') }}
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> {{ trans('admin.name') }} </th>
                                <th width="15%"> {{ trans('admin.action') }} </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.tags.form')

@endsection

@push('scripts')

<script>
    var tag_id = '';
    $(document).ready(function() {

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('tags.index') }}",
            },
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    searchable: false,
                    orderable: false
                },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false }
            ]
        });

        $('#create_tag').click(function() {
            $('.modal-title').text('{{ trans('admin.add_new_tag') }}');
            $('#action_button').val('Add');
            $('#tagForm').trigger('reset');
            $('#action').val('Add');
            $('#tagModal').modal('show');
        });

        $('#tagForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Add') {
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('tags.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            $('#tagForm')[0].reset();
                            $('#data-table').DataTable().ajax.reload();
                            $('#tagModal').modal('hide');
                            toastr.success('{{ trans('admin.added_done') }}!', '{{ trans('admin.success') }}!');
                        }
                        $('#form_result').html(html);
                    }
                });
            }
            if ($('#action').val() == "Edit") {
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('tags.update') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            $('#tagForm')[0].reset();
                            $('#data-table').DataTable().ajax.reload();
                            $('#tagModal').modal('hide');
                            toastr.success('{{ trans('admin.edited_done') }}!', '{{ trans('admin.success') }}!');
                        }
                        $('#form_result').html(html);
                    }
                });
            }
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url: "/admin/tags/" + id + "/edit",
                dataType: "json",
                success: function(html) {
                    $('#name').val(html.data.name);
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('{{ trans('admin.edit_tag') }}');
                    $('#action_button').val('Edit');
                    $('#action').val('Edit');
                    $('#tagModal').modal('show');
                }
            });
        });

        $(document).on('click', '.delete', function() {
            tag_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('{{ trans('admin.confirmation') }}');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "tags/destroy/" + tag_id,
                beforeSend: function() {
                    $('#ok_button').text('{{ trans('admin.deleting') }}...');
                },
                success: function(data) {
                    $('#confirmModal').modal('hide');
                    $('#data-table').DataTable().ajax.reload();
                    $('#ok_button').html('<i class="fa fa-check" aria-hidden="true"></i> Delete');
                    toastr.success('{{ trans('admin.deleted_done') }}!', '{{ trans('admin.success') }}!');
                },
                error: function(data) {
                    console.log('error:', data);
                    $('#ok_button').html('<i class="fa fa-check" aria-hidden="true"></i> Delete');
                }
            });
        });
    });

</script>

@endpush