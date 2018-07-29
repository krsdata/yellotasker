<!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2017 &copy; Yellotasker

            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>


        <!-- END QUICK NAV -->

        <!-- BEGIN CORE PLUGINS -->
         <script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ URL::asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset('assets/pages/scripts/table-datatables-editable.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ URL::asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>

         <script src="{{ URL::asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-markdown/lib/markdown.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset('assets/pages/scripts/form-validation.js') }}" type="text/javascript"></script>

         <script src="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>



        <script src="{{ URL::asset('assets/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>

        <script src="{{ URL::asset('assets/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>


        <script src="{{ URL::asset('assets/pages/scripts/ui-buttons.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>

        <script src="{{ URL::asset('assets/js/components-bootstrap-multiselect.min.js') }}" type="text/javascript"></script>

        <!-- END THEME LAYOUT SCRIPTS -->
      @if(isset($js_file))

        @foreach($js_file as $key => $js )
              <script src="{{ URL::asset('assets/js/'.$js) }}" type="text/javascript"></script>
        @endforeach
        @else
         <script src="{{ URL::asset('assets/js/common.js') }}" type="text/javascript"></script>
         <script src="{{ URL::asset('assets/js/bootbox.js') }}" type="text/javascript"></script>
          <script src="{{ URL::asset('assets/js/formValidate.js') }}" type="text/javascript"></script>
          <script src="{{ URL::asset('assets/js/angular.js')}}"></script>
          <script src="{{ URL::asset('assets/js/app.js?q=dbfjsbjgbdg')}}"></script>
      @endif

      <script type="text/javascript">

          var   email_req = "Please enter email";
          var  password_req = "Please enter password";
          var url = "{{ url::to('/')}}";
          $(document).ready(function(){
            $('#saveBtn').click(function(){
                $('.scroll-to-top').trigger('click');
            });
          });
          $(document).ready(function() {
              $(".phone").keydown(function (e) {
                  // Allow: backspace, delete, tab, escape, enter and .
                  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                       // Allow: Ctrl+A, Command+A
                      (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                       // Allow: home, end, left, right, down, up
                      (e.keyCode >= 35 && e.keyCode <= 40)) {
                           // let it happen, don't do anything
                           return;
                  }
                  // Ensure that it is a number and stop the keypress
                  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                      e.preventDefault();
                  }
              });
          });
      </script>


    </body>


    <style type="text/css">
  .cke_button__source{
    display: none !important;
  }
  .cke_button__source_label{
    display: none !important;
  }
  .cke_toolbar{
    // display: none !important;
  }
</style>

</html>
