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
                <a href="/admin/comments">{{ trans('admin.comments') }}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-comments font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{ trans('admin.comments') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button name="create_comment" id="create_comment" class="btn green">
                                        {{ trans('admin.add_new') }}
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
                                <th> {{ trans('admin.post') }} </th>
                                <th> {{ trans('admin.comment') }} </th>
                                <th width="15%"> {{ trans('admin.action') }} </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.comments.form')

@endsection

@push('scripts')

<script>
    var comment_id = '';
    $(document).ready(function() {

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('comments.index') }}",
            },
            columns: [{
                    render: function(data, type, row, meta) {
                        console.log(meta);
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    searchable: false,
                    orderable: false
                },
                { data: 'post', name: 'post' },
                { data: 'content', name: 'content' },
                { data: 'action', name: 'action', orderable: false }
            ]
        });

        $('#create_comment').click(function() {
            $('.modal-title').text('{{ trans('admin.add_new_comment') }}');
            $('#action_button').val('Add');
            $('#commentForm').trigger('reset');
            $('.select2').val('').trigger('change');
            $('#action').val('Add');
            $('#commentModal').modal('show');
        });

        $('#commentForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Add') {
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('comments.store') }}",
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
                            $('#commentForm')[0].reset();
                            $('#data-table').DataTable().ajax.reload();
                            $('#commentModal').modal('hide');
                            toastr.success('{{ trans('admin.added_done') }}!', '{{ trans('admin.success') }}!');
                        }
                        $('#form_result').html(html);
                    }
                });
            }
            if ($('#action').val() == "Edit") {
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('comments.update') }}",
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
                            $('#commentForm')[0].reset();
                            $('#data-table').DataTable().ajax.reload();
                            $('#commentModal').modal('hide');
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
                url: "/admin/comments/" + id + "/edit",
                dataType: "json",
                success: function(html) {
                    $('#content').val(html.data.content);
                    $('#post_id').val(html.data.post_id).trigger('change');
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('{{ trans('admin.edit_comment') }}');
                    $('#action_button').val('Edit');
                    $('#action').val('Edit');
                    $('#commentModal').modal('show');
                }
            });
        });

        $(document).on('click', '.delete', function() {
            comment_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('{{ trans('admin.confirmation') }}');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "comments/destroy/" + comment_id,
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

    $('.select2').select2({
        placeholder: "{{ trans('admin.select_post') }}"
    });

</script>

@endpush