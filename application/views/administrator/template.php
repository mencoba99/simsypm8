<?php 
if ($this->session->level==''){
    redirect(base_url());
}else{
$sekolah = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array(); 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMASTA</title>
    <meta name="author" content="limakode.com">
    <link rel="icon" type="image/x-icon" href="https://www.limakode.com/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="asset/admin/dist/img/sekolah_ypm.png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/admin/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/skins/_all-skins.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datetimepicker/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer-in.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <style type="text/css"> .files{ position:absolute; z-index:2; top:0; left:0; filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; opacity:0; background-color:transparent; color:transparent; } </style>
    <script type="text/javascript" src="<?php echo base_url(); ?>/asset/admin/plugins/jQuery/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url(''); ?>asset/ckeditor/ckeditor.js"></script>
    <style type="text/css">#example thead tr, #table1 thead tr, #example1 thead tr, #example2 thead tr{ background-color: #e3e3e3; } .checkbox-scroll { border:1px solid #ccc; width:100%; height: 114px; padding-left:8px; overflow-y: scroll; }</style>
    <link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/plugins/pace/pace.min.css">
    <link href="<?php echo base_url(); ?>asset/admin/plugins/combobox/bootstrap-combobox.css" media="screen" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript">
      function popup(url) {
        newwindow=window.open(url,'name','height=500,width=740');
        if (window.focus) {newwindow.focus()}
        return false;
      }
      function auto_grow(element) { element.style.height = "5px"; element.style.height = (element.scrollHeight)+"px"; }
    </script>
    <script type="text/javascript">
    function check_semua(source) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i] != source)
              checkboxes[i].checked = source.checked;
      }
    }
    
    function nospaces(t){
        if(t.value.match(/\s/g)){
            alert('Maaf, Tidak Boleh Menggunakan Spasi,..');
            t.value=t.value.replace(/\s/g,'');
        }
    }

    $(document).ready(function(){
        $(".input").keyup(function(){
              var val1 = +$(".value1").val();
              var val2 = +$(".value2").val();
              var val3 = +$(".value3").val();
              $("#result").val(Math.round((val1+val2+val3)/3));
       });
    });

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            function addCommas(nStr){
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
        
        $(".input1").keyup(function(){
              var val1 = +$(".value1").val();
              var val2 = +$(".value2").val();
              $("#hasilnya").val(addCommas(val2-val1));
       });
    });
    </script>

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
          <?php include "main-header.php"; ?>
      </header>

      <aside class="main-sidebar" style='position:fixed; overflow:auto; max-height:100%'>
          <?php 
            if($this->session->level=='admin' OR $this->session->level=='user'){
              include "menu/unit_$sekolah[id_jenjang]/menu-admin.php"; 
            }elseif($this->session->level=='guru'){
              include "menu/unit_$sekolah[id_jenjang]/menu-guru.php"; 
            }elseif($this->session->level=='siswa'){
              include "menu/unit_$sekolah[id_jenjang]/menu-siswa.php"; 
            }
          ?>
      </aside>

      <div class="content-wrapper" style='padding-top: 60px;'>
       

        <section class="content">
            <?php echo $contents; ?>
        </section>
        <div style='clear:both'></div>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
          <?php include "footer.php"; ?>
      </footer>
          <?php include "iklan.php"; ?>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->

    <script src="<?php echo base_url(); ?>asset/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>$.widget.bridge('uibutton', $.ui.button);</script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>asset/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://almsaeedstudio.com/themes/AdminLTE/plugins/pace/pace.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>asset/admin/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>asset/admin/dist/js/app.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/dist/js/bootstrap-clockpicker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/admin/plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/dist/js/jquery.nestable.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/combobox/bootstrap-combobox.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
          $('.combobox').combobox()
        });
    </script>
   <script type="text/javascript">
      $('.textarea').wysihtml5();
      $('.clockpicker').clockpicker();
      $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });
      $('.datepicker1').datepicker({
            format: "dd-mm-yyyy"
        });
      $('.datepicker2').datepicker({
            format: "dd-mm-yyyy"
        });
      $('.datepicker3').datepicker({
            format: "dd-mm-yyyy"
        });
        
    $('.datepicker4').datepicker({
            format: "dd-mm-yyyy"
        });
        
    $('.datepicker5').datepicker({
            format: "dd-mm-yyyy"
        });

            $(function () {
                $('#datetimepicker1').datetimepicker();
                $('#datetimepicker2').datetimepicker();
                $('.form_datetime').datetimepicker();
            });
    </script>
    <script>
    $('#rangepicker').daterangepicker({
        format: 'DD-MM-YYYY'
      });
    $('.datepicker').datepicker();
      $(function () { 
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>

  <script>
    CKEDITOR.replace('editor1' ,{
      filebrowserImageBrowseUrl : '<?php echo base_url('asset/kcfinder'); ?>'
    });
  </script>
  <script type="text/javascript">
  // To make Pace works on Ajax calls
  $(document).ajaxStart(function() { Pace.restart(); });
    $('.ajax').click(function(){
        $.ajax({url: '#', success: function(result){
            $('.ajax-content').html('<hr>Ajax Request Completed !');
        }});
    });


    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
       return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
       return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');


    $(document).ready(function() {
        if (location.hash) {
            $("a[href='" + location.hash + "']").tab("show");
        }
        $(document.body).on("click", "a[data-toggle]", function(event) {
            location.hash = this.getAttribute("href");
        });
    });
    $(window).on("popstate", function() {
        var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
        $("a[href='" + anchor + "']").tab("show");
    });
  </script>

  <script>
        $(function(){
            $(document).on('click','.tambah-labor',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post("<?php echo site_url().$this->uri->segment(1); ?>/tambah_labor_detail",
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
    </script>

    <script>
        $(function(){
            $(document).on('click','.edit-labor',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post("<?php echo site_url().$this->uri->segment(1); ?>/edit_labor_detail",
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
    </script>

    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-body"></div>
              <div class="modal-footer"></div>
          </div>
      </div>
    </div>
  </body>
</html>
<?php } ?>
