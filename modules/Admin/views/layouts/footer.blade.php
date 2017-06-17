<div id="confirm" class="modal hide fade">
    <div class="modal-body">
        Are you sure?
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
    </div>
</div>

<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; {{date('Y')}} <a href="{{ url('/')}}">Syncabi</a>.</strong> All rights reserved.
      </footer>
 
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
 <!-- jQuery 2.1.4 -->
    <script src="{{ URL::asset('public/assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('public/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ URL::asset('public/assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ URL::asset('public/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('public/assets/plugins/knob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ URL::asset('public/assets/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ URL::asset('public/assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ URL::asset('public/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ URL::asset('public/assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('public/assets/plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('public/assets/dist/js/app.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('public/assets/dist/js/demo.js') }}"></script>
     <script src="{{ URL::asset('public/assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/jquery.validate.js') }}"></script>

    <script src="{{ URL::asset('public/assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/bootbox.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/common.js') }}"></script>
    
    <script type="text/javascript">
        $(".select2").select2();
        var url = "{{ url('admin') }}";
        var email_req = '{{ Lang::get('immoclick-lang.email_req') }}';
        var password_req = '{{ Lang::get('immoclick-lang.password_req') }}';
        $(function(){
             $('#datepicker').datepicker({
              autoclose: true
            }); 
        }); 

    </script>  
  
</script>
     
  </body>
</html>
