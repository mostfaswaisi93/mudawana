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
                <a href="/admin/posts">{{ trans('admin.posts') }}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-sticky-note-o font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{ trans('admin.posts') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button name="create_post" id="create_post" class="btn green">
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
                                <th> {{ trans('admin.title') }} </th>
                                <th> {{ trans('admin.author') }} </th>
                                <th> {{ trans('admin.tags') }} </th>
                                <th> {{ trans('admin.published') }} </th>
                                <th width="22%"> {{ trans('admin.action') }} </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.posts.form')

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>

<script>
    var post_id = '';
    $(document).ready(function() {

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('posts.index') }}",
            },
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    searchable: false,
                    orderable: false
                },
                { data: 'title', name: 'title' },
                { data: 'author', name: 'author' },
                { data: getTags, name: 'tags' },
                { data: 'published', name: 'published' },
                { data: 'action', name: 'action', orderable: false }
            ],
            "columnDefs": [{
                "targets": 4,
                render: function(data, type, row, meta) {
                    var $select = $(`<select class='published form-control'
                    id='published' onchange=selectPublished(${row.id})>
                    <option value='1'>{{ trans('admin.published') }}</option>
                    <option value='0'>{{ trans('admin.not_published') }}</option>
                    </select>`);
                    $select.find('option[value="' + row.published + '"]').attr('selected', 'selected');
                    return $select[0].outerHTML
                }
            }]
        });

        function getTags(data, type, full, meta) {
            var orderType = data.DataType;
            var nameTage = JSON.parse(data.tags.replace(/&quot;/g, '"'));
            var fName = '';
            nameTage.forEach(element => {
                fName += "<span class='badge badge-primary'>" + element.name + "</span> ";
            });
            return fName;
        }

        $('#create_post').click(function() {
            $('.modal-title').text('{{ trans('admin.add_new_post') }}');
            $('#action_button').val('Add');
            $('#postForm').trigger('reset');
            CKEDITOR.instances['body'].setData('');
            $('.selectTag').val('').trigger('change');
            $('#action').val('Add');
            $('#postModal').modal('show');
        });

        $('#postForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Add') {
                var formData = new FormData(this);
                var bodyValue = '';
                bodyValue = CKEDITOR.instances['body'].getData();
                formData.append('body', bodyValue);
                $.ajax({
                    url: "{{ route('posts.store') }}",
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
                            $('#postForm')[0].reset();
                            $('#data-table').DataTable().ajax.reload();
                            $('#postModal').modal('hide');
                            toastr.success('{{ trans('admin.added_done') }}!', '{{ trans('admin.success') }}!');
                        }
                        $('#form_result').html(html);
                    }
                });
            }
            if ($('#action').val() == "Edit") {
                var formData = new FormData(this);
                var bodyValue = '';
                bodyValue = CKEDITOR.instances['body'].getData();
                formData.append('body', bodyValue);
                $.ajax({
                    url: "{{ route('posts.update') }}",
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
                            $('#postForm')[0].reset();
                            $('#data-table').DataTable().ajax.reload();
                            $('#postModal').modal('hide');
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
                url: "/admin/posts/" + id + "/edit",
                dataType: "json",
                success: function(html) {
                    var tags = html.data.tags;
                    var tag_ids = _.map(tags, 'id');
                    $('#title').val(html.data.title);
                    $('#author').val(html.data.author);
                    CKEDITOR.instances['body'].setData(html.data.body);
                    $('#tag_id > option').prop('selected', false);
                    $('#tag_id > option').each(function() {
                        var item = this;
                        if (tag_ids.indexOf(parseInt(item.value)) > -1) {
                            $(this).prop('selected', true).trigger('change');
                        } else {
                            console.log('selected', false);
                        }
                    });
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('{{ trans('admin.edit_post') }}');
                    $('#action_button').val('Edit');
                    $('#action').val('Edit');
                    $('#postModal').modal('show');
                }
            });
        });

        $(document).on('click', '.showBtn', function() {
            post_id = $(this).attr('id');
            $.ajax({
                url: "/admin/posts/" + post_id,
                dataType: "json",
                success: function(html) {
                    var tags = html.data.tags;
                    var tag_ids = _.map(tags, 'id');
                    $('#showTilte').html(html.data.title);
                    $('#showAuthor').html(html.data.author);
                    $('#showTags > option').prop('selected', false);
                    $('#showTags > option').each(function() {
                        var item = this;
                        if (tag_ids.indexOf(parseInt(item.value)) > -1) {
                            $(this).prop('selected', true).trigger('change');
                        } else {
                            console.log('selected', false);
                        }
                    });
                    $('#showBody').html(html.data.body);
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('{{ trans('admin.show_post') }}');
                    $('#showModal').modal('show');
                }
            });
        });

        $(document).on('click', '.delete', function() {
            post_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('{{ trans('admin.confirmation') }}');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "posts/destroy/" + post_id,
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

        $(document).on('change', '#published', function(e) {
            var published_post = $(this).find("option:selected").val();
            if (published_post == true) {
                toastr.success('{{ trans('admin.published_changed') }}!', '{{ trans('admin.success') }}!');
            } else {
                toastr.success('{{ trans('admin.published_changed') }}!', '{{ trans('admin.success') }}!');
            }
            $.ajax({
                url: "posts/updatePublished/" + post_id + "?published=" + published_post,
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}"
                },
                method: "POST",
                data: {},
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
                        $('#data-table').DataTable().ajax.reload();
                    }
                }
            });
        });

    });

    function selectPublished(id) {
        post_id = id;
    }

    CKEDITOR.replace('body', {
        height: 150,
    });

    $('.selectTag').select2({
        placeholder: "{{ trans('admin.select_tags') }}",
        allowClear: true
    });

    $(".selectTags").select2();
    $('.selectTags').prop("disabled", true);

</script>

@endpush