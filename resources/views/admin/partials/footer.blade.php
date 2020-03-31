<div class="page-footer">
    <div class="page-footer-inner">
        All rights are saved
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"
    type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
    type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript">
</script>
<script src="{{ url('/design/metronic-ltr/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
    type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/plugins/datatables/datatables.min.js') }}"
    type="text/javascript"></script>
<script
    src="{{ url('/design/metronic-ltr/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
    type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/pages/scripts/table-datatables-editable.min.js') }}"
    type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript">
</script>
<script src="{{ url('/design/metronic-ltr/assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript">
</script>
<script src="{{ url('/design/metronic-ltr/assets/layouts/global/scripts/quick-sidebar.min.js') }}"
    type="text/javascript"></script>
<script src="{{ url('/design/metronic-ltr/assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript">
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>

@stack('scripts')

@if (direction() == 'ltr')
@else
<script>
    $('.selectTag').select2({
        placeholder: "{{ trans('admin.select_tags') }}",
        dir: "rtl",
        allowClear: true
    });
    $(".selectTags").select2({
        dir: "rtl"
    });

    CKEDITOR.config.contentsLangDirection = 'rtl';
</script>
@endif

</body>

</html>