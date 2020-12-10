<script src="{{ asset('public/admins/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/admins/js/main.js') }}"></script>
{{-- <script src="{{ asset('public/admins/js/plugins/pace.min.js') }}"></script> --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{ asset('public/js/app.js') }}"></script>

<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="{{ asset('public/slick/slick.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script charset="utf-8" type="text/javascript" src="http://torifat.github.io/jsAvroPhonetic/libs/avro-keyboard/dist/avro-v1.1.4.min.js"></script>
<script src="{{ asset('public/admins/js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/admins/js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('public/admins/js/custom.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

{{-- SimpleBar Script --}}
<script src="https://unpkg.com/simplebar@latest/dist/simplebar.js"></script>


<script>
	$(document).ready(function() {

	  var table = $('#datatable').DataTable({
          // "scrollY": "350px",
          "paging": true,
          "pageLength": 50,
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      });

	  $('a.toggle-vis').on( 'click', function (e) {
			e.preventDefault();

        // Get the column API object
        var column = table.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible() );
     });

        $('#demoDate').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        });
	});
</script>
<script type="text/javascript">
  $(document).ready(function() {

    {{-- ToolTip --}}
    //$("body").tooltip({ selector: '[data-toggle=tooltip]' });

    {{-- SideBar Scroll Heplper --}}
    $(".app-sidebar").click(function(){
      if ($(".simplebar-offset").css('bottom') == '-17px') {
        document.getElementById('app-sidebar__toggle').click();
      }
    });
    $(".app-sidebar").hover(function(){
      if ($(".simplebar-offset").css('bottom') == '-17px') {
        document.getElementById('app-sidebar__toggle').click();
      }
    });
  });
</script>
