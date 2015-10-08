<?php
session_start();
if (!empty($_SESSION['namauser'])) {
    include "config/koneksi.php";
    include "config/library.php";
    ?>
    <html lang="en">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <meta charset="utf-8">
            <title>Informasi Pengajuan Skripsi</title>
            <meta name="generator" content="Bootply" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="" rel="shortcut icon" type="image/vnd.microsoft.icon" />
            <!--[if lt IE 9]>
                    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
            <link href="css/styles.css" rel="stylesheet">
        </head>
        <body>
            <!-- Header -->
            <div id="top-nav" class="navbar navbar-inverse navbar-static-top" style="background: rgb(101,169,211); /* Old browsers */
                 background: -moz-linear-gradient(top, rgb(101,169,211) 0%, rgb(41,137,216) 50%, rgb(32,124,202) 62%, rgb(0,130,224) 100%); /* FF3.6+ */
                 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(101,169,211)), color-stop(50%,rgb(41,137,216)), color-stop(62%,rgb(32,124,202)), color-stop(100%,rgb(0,130,224))); /* Chrome,Safari4+ */
                 background: -webkit-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* Chrome10+,Safari5.1+ */
                 background: -o-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* Opera 11.10+ */
                 background: -ms-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* IE10+ */
                 background: linear-gradient(to bottom, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* W3C */
                 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#65a9d3', endColorstr='#0082e0',GradientType=0 ); /* IE6-9 */">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i> <?php echo (!empty($_SESSION['namalengkap']) ? $_SESSION['namalengkap'] : "Admin") ?><span class="caret"></span></a>
                                <ul id="g-account-menu" class="dropdown-menu" role="menu">
                                    <li><a href="users" > Profil</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-comment"></i> Menu <span class="caret"></span></a>
                                <ul id="g-account-menu" class="dropdown-menu" role="menu">
                                    <li><a href="pengajuan" > Pengajuan Skripsi </a></li>
                                    <li><a href="pembimbing" > Detail Skripsi </a></li>
                                </ul>
                            </li>
                            <li><a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </div><!-- /container -->
            </div>
            <!-- /Header -->

            <!-- Main -->
            <div class="container-fluid" style="min-height: 450px">
                <div class="row">
                    <div class="col-sm-3" style="">
                        <!-- Left column -->
                        <a href="javascript:void(0);"><i class="glyphicon glyphicon-list"></i> <strong> Informasi Pengajuan Skripsi</strong></a>  

                        <hr>

                        <ul class="list-unstyled">
                            <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu">
                                    <h5>Menu <i class="glyphicon glyphicon-chevron-down"></i></h5>
                                </a>
                                <ul class="list-unstyled collapse in" id="userMenu">
                                    <li><a href="pengajuan" ><i class="glyphicon glyphicon-envelope"></i> Pengajuan Skripsi </a></li>
                                    <li><a href="pembimbing" ><i class="glyphicon glyphicon-envelope"></i> Detail Skripsi </a></li>
                                    <li><a href="users" ><i class="glyphicon glyphicon-user"></i> Users</a></li>
                                    <?php
                                    if ($_SESSION['leveluser'] == 'admin') {
                                        echo '<li><a href="#" data-toggle="modal" data-target="#inputdosen"><i class="glyphicon glyphicon-warning-sign"></i> Import Dosen</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#inputmhs"><i class="glyphicon glyphicon-warning-sign"></i> Import Mahasiswa</a></li>';
                                    }
                                    ?>
                                    <li><a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /col-3 -->
                    <div class="col-sm-9">
                        <a href="javascript:void(0);"><strong><i class="glyphicon glyphicon-folder-close"></i> <?php echo $_GET['module']; ?></strong></a>  
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    <div id="pesan_reset">
                                    </div>
                                    <?php include "content.php"; ?>
                                </ul>
                            </div>
                        </div>
                    </div><!--/col-span-9-->
                </div>
            </div>
            <!-- /Main -->
            <!-- /Main -->
            <div class="modal fade" id = "inputdosen">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Import Data Dosen</h4>
                        </div>
                        <div class="modal-body">
                            <form id ="unggahdosen" enctype='multipart/form-data'>
                                <div class="form-group">
                                    <label>Data Format xls excel 2003</label>
                                    <input name="file" type="file" id="file" size="50"/><span class="unggahi" style="color:red"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "upload('unggahdosen','dosen')">Input</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" id = "inputmhs">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Import Data Mahasiswa</h4>
                        </div>
                        <div class="modal-body">
                            <form id ="unggahmhs" enctype='multipart/form-data'>
                                <div class="form-group">
                                    <label>Data Format xls excel 2003</label>
                                    <input name="file" type="file" id="file" size="50"/><span class="unggahi" style="color:red"></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "upload('unggahmhs','mhs')">Input</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <footer class="text-center">
                <div style="text-align: center;">Copyright &COPY; 2015 Universitas Muhamadiyah Surakarta</div>
                <div style="text-align: center;font-size: 11;">Powered By <a href="http://scripthouse.co.id/" style="color:#000" target="_blank">Script House</a></div>
            </footer>
        </body>
    </html>
    <?php
} else {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN </b></a></center>";
}
?>
<!-- script references -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/easyui/easyloader.js"></script>
<script type="text/javascript" src="js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="js/easyui/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>

<script type="text/javascript">
    var myApp;
    myApp = myApp || (function () {
        var pleaseWaitDiv = $('<div id="pleaseWaitDialog" class="progress" data-keyboard="false"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">Please Wait </span></div></div>');
        return {
            showPleaseWait: function() {
                pleaseWaitDiv.modal();
            },
            hidePleaseWait: function () {
                pleaseWaitDiv.modal('hide');
            }

        };
    })();
    function menu(actions){
        myApp.showPleaseWait();
        $.ajax({
            type: 'POST',
            url: ''+actions+'',
            success: function(data) {
                $('.list-group').html(data);
                myApp.hidePleaseWait();
            },
            error: function(x, t, m) {
                if(t==="timeout") {
                    $.messager.alert('Message', "Koneksi Lambat.. Cobalah Kembali!?", 'warning');
                    myApp.hidePleaseWait();
                } else {
                    $.messager.alert('Message', t, 'warning');
                    myApp.hidePleaseWait();
                }
            } 
        });
    }
    
    function upload(form,act){
        $(".unggahi").html("<blink>Mohon Tunggu.. Proses Upload</blink>");
        var data = new FormData($("#"+form)[0]);
        $.ajax({
            type: 'POST',
            url: '<?php echo "upload_?act="; ?>'+act,
            data: data,
            async: false,
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.status == 0){
                    $("#pesan_reset").html("<div class='alert alert-success' role='alert'>"+data.msg+"</div>");
                    $("#"+form).trigger("reset");
                    $(".unggahi").html("");
                }else{
                    $("#pesan_reset").html("<div class='alert alert-danger' role='alert'>"+data.msg+"</div>");
                    $("#"+form).trigger("reset");
                    $(".unggahi").html("");
                }
            },
            dataType:"json",
            error: function(x, t, m) {
                if(t==="timeout") {
                    $("#pesan_reset").html("<div class='alert alert-danger' role='alert'>Koneksi Lambat.. Cobalah Kembali!?</div>");
                    $(".unggahi").html("");
                } else {
                    $("#pesan_reset").html("<div class='alert alert-danger' role='alert'>"+t+"</div>");
                    $(".unggahi").html("");
                }
            } 
        });
    }
	
</script>