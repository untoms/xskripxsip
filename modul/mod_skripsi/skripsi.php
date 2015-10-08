<?php
$aksi = "pengajuan_";
include "config/fungsi_combobox.php";
?> 
<!-- get Pembibing -->
<body onload="getData('','?module=skripsi&act=select')"></body>
<!-- -->
<div id="pesan">
</div>
<div id="grid">
    <div id="tb">  
        <div class="navbar-form navbar" >
            <div class="form-group">
                <select id="sortby"  class="form-control">
                    <option value="nomor"> Nomer </option>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control" id="find" placeholder="Search" onkeyup="cari()"/>
            </div>
            <?php
            if ($_SESSION['leveluser'] == 'guest') {
                echo '<button type="button" id="tambah" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#add" >Tambah</button>';
            }
            ?>
        </div>
    </div>
    <table id="tt" class="easyui-datagrid" style="height: 400px; width: 100%;" url="<?php echo $aksi . "?module=skripsi&act=load"; ?>" title="Daftar Pengajuan Skripsi" rownumbers="true" toolbar="#tb" pagination="true">

        <thead data-options="frozen:true">
            <tr>
                <th field="nomor" width="150" sortable="true">Nomor</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th field="nama" width="200" sortable="true">Nama</th>
                <th field="nim" width="150" sortable="true">Nim</th>
                <th field="judul" width="300" sortable="true">judul</th>
                <th field="tgl" width="150" sortable="true">Tanggal</th>
                <th field="pbnama1" width="200" sortable="true">Pembimbing 1</th>
                <th field="pbnama2" width="200" sortable="true">Pembimbing 2</th>
                <th field="link" width="300" sortable="true">Link File</th>
                <th field="status" width="100" sortable="true">Status</th>
                <th field="aksi" width="100" sortable="true">Aksi</th>
            </tr>
        </thead>        
    </table>
</div> 

<div class="modal fade" id = "add" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(101,169,211); /* Old browsers */
                 background: -moz-linear-gradient(top, rgb(101,169,211) 0%, rgb(41,137,216) 50%, rgb(32,124,202) 62%, rgb(0,130,224) 100%); /* FF3.6+ */
                 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(101,169,211)), color-stop(50%,rgb(41,137,216)), color-stop(62%,rgb(32,124,202)), color-stop(100%,rgb(0,130,224))); /* Chrome,Safari4+ */
                 background: -webkit-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* Chrome10+,Safari5.1+ */
                 background: -o-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* Opera 11.10+ */
                 background: -ms-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* IE10+ */
                 background: linear-gradient(to bottom, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* W3C */
                 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#65a9d3', endColorstr='#0082e0',GradientType=0 ); /* IE6-9 */">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Pengajuan Skripsi</h4>
            </div>
            <div class="modal-body">
                <form id ="skripsi" >
                    <div class="form-group">
                        <input class="form-control" name = "nim" id = "nim1"  title="Nim" value ="<?php echo $_SESSION['nik']; ?>"placeholder="Nim" />
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "nama" id = "nama1"   title="Nama" value="<?php echo $_SESSION['namalengkap']; ?>" placeholder="Nama" />
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "tgl" id = "tgl1" readonly value ="<?php echo date("d-m-Y H:i:s") ?>"  title ="Tanggal" placeholder="Tanggal"/>
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "instansi" id = "instansi1"   title="Instansi"  placeholder="Instansi" />
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "kota" id = "kota1"   title="Kota"  placeholder="Kota" />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name = "judul" id = "judul1" title ="Judul Skripsi" placeholder="Judul Skripsi"></textarea>
                    </div>
                    <!-- <div class="form-group">
                         <select class="form-control" name="konsentrasi" id="konsentrasi1" onchange ="getData('','?module=skripsi&act=select')" id="konsentrasi">
                             <option value="0"> Pilih Konsentrasi</option>
                             <option value ="Manajemen Keuangan"> Manajemen Keuangan</option>
                             <option value ="Manajemen Pemasaran"> Manajemen Pemasaran</option>
                             <option value ="Manajemen SDM"> Manajemen SDM</option>
                         </select>
                     </div> -->
                    <div class="form-group">
                        <select class="form-control" name="kodepembimbing1" id="bimbing1">
                            <option value="0"> Pembimbing 1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="kodepembimbing2" id="bimbing2">
                            <option value="0"> Pembimbing 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <a href="http://www.4shared.com/" target ="_blank"><img src="image/4shared.png" height="45" width="35"></img></a>&nbsp;&nbsp;
                        <a href="https://www.google.com/drive/" target ="_blank"><img src="image/drive.png" height="45" width="35"></img></a>&nbsp;&nbsp;
                        <a href="https://www.mediafire.com/" target ="_blank"><img src="image/mediafire.png" height="45" width="35"></img></a>&nbsp;&nbsp;
                    </div>
                    <div class="form-group">
                        <input class="form-control" name = "link"  title ="Link File" placeholder="Copy Link Url File Here"/>
                    </div>
                    </fieldset>
                </form>	
            </div>	
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "trans('?module=skripsi&act=save','skripsi')" >Simpan</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id = "edit" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(101,169,211); /* Old browsers */
                 background: -moz-linear-gradient(top, rgb(101,169,211) 0%, rgb(41,137,216) 50%, rgb(32,124,202) 62%, rgb(0,130,224) 100%); /* FF3.6+ */
                 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(101,169,211)), color-stop(50%,rgb(41,137,216)), color-stop(62%,rgb(32,124,202)), color-stop(100%,rgb(0,130,224))); /* Chrome,Safari4+ */
                 background: -webkit-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* Chrome10+,Safari5.1+ */
                 background: -o-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* Opera 11.10+ */
                 background: -ms-linear-gradient(top, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* IE10+ */
                 background: linear-gradient(to bottom, rgb(101,169,211) 0%,rgb(41,137,216) 50%,rgb(32,124,202) 62%,rgb(0,130,224) 100%); /* W3C */
                 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#65a9d3', endColorstr='#0082e0',GradientType=0 ); /* IE6-9 */">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Pengajuan Skripsi</h4>
            </div>
            <div class="modal-body">
                <form id ="eskripsi" >
                    <input type ="hidden" name = "nomor" id = "nomor" />
                    <input type ="hidden" name = "statuscek" id = "statuscek" />
                    <div class="form-group">
                        <input class="form-control" name = "nim" readonly id = "nim" title="Nim" placeholder="Nim" />
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "nama"  readonly id = "nama" title="Nama"  placeholder="Nama" />
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "tgl" readonly  id = "tgl" title ="Tanggal" placeholder="Tanggal"/>
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "instansi" readonly id = "instansi" title="Instansi"  placeholder="Instansi" />
                    </div>
                    <div class="form-group">	
                        <input class="form-control" name = "kota"  readonly id = "kota" title="Kota"  placeholder="Kota" />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name = "judul" id="judul"title ="Judul Skripsi" placeholder="Judul Skripsi"></textarea>
                    </div>
                    <!--<div class="form-group">
                        <select class="form-control" name="konsentrasi" readonly onchange ="getData('','?module=skripsi&act=select')" id="option3">
                        </select>
                    </div>-->
                    <div class="form-group">
                        <select class="form-control" readonly name="kodepembimbing1" id="option1">
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" readonly name="kodepembimbing2" id="option2">
                        </select>
                    </div>
                    <div class="form-group">
                        <a href="http://www.4shared.com/" target ="_blank"><img src="image/4shared.png" height="45" width="35"></img></a>&nbsp;&nbsp;
                        <a href="https://www.google.com/drive/" target ="_blank"><img src="image/drive.png" height="45" width="35"></img></a>&nbsp;&nbsp;
                        <a href="https://www.mediafire.com/" target ="_blank"><img src="image/mediafire.png" height="45" width="35"></img></a>&nbsp;&nbsp;
                    </div>
                    <div class="form-group">
                        <input class="form-control" name = "link" readonly id="link" title ="Link File" placeholder="Copy Link Url File Here"/>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="status" id="option4">
                        </select>
                    </div>
                    </fieldset>
                </form>	
            </div>	
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "trans('?module=skripsi&act=update','eskripsi')" >Update</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="wait"></div> 
<script type="text/javascript">
    
    function cari(){
        $('#tt').datagrid('load',{
            data: $('#find').val(),
            sortby: $('#sortby').val(),
            cari:'1'
        });
    }

    function getData(where,url){
        $.ajax({
            type: 'POST',
            url: '<?php echo $aksi; ?>'+url,
            //data:'konsentrasi='+$("#konsentrasi1").val(),
            data:'konsentrasi=',
            success: function(data) {
                $("#bimbing1").html(data.option1);
                $("#bimbing2").html(data.option2);
            },
            dataType:"json",
            error: function(x, t, m) {
                if(t==="timeout") {
                    $("#pesan").html("<div class='alert alert-danger' role='alert'>Koneksi Lambat Coba Kembali</div>");
                } else {
                    $("#pesan").html("<div class='alert alert-danger' role='alert'>"+t+"</div>");
                }
            } 
        });
    }
    
    function SelectData(nomor,nim,url){
        $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
        $.ajax({
            type: 'POST',
            url: '<?php echo $aksi; ?>'+url,
            data:'nim='+nim+"&nomor="+nomor,
            success: function(data) {
                $("#option1").html(data.option1);
                $("#option2").html(data.option2);
                $("#option3").html(data.option3);
                $("#option4").html(data.option4);
                $("#nama").val(data.nama);
                $("#nim").val(data.nim);
                $("#nomor").val(data.nomor);
                $("#statuscek").val(data.status);
                $("#tgl").val(data.tgl);
                $("#kota").val(data.kota);
                $("#judul").html(data.judul);
                $("#instansi").val(data.instansi);
                $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
            },
            dataType:"json",
            error: function(x, t, m) {
                if(t==="timeout") {
                    $("#pesan").html("<div class='alert alert-danger' role='alert'>Koneksi Lambat Coba Kembali</div>");
                    $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                } else {
                    $("#pesan").html("<div class='alert alert-danger' role='alert'>"+t+"</div>");
                    $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                }
            } 
        });
    }
	
    function trans(url,id){
        if($("#nomer1").val() == "" && id == "skripsi"){
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Nomor Harus Di isi</div>");
        }else if($("#nim1").val() == "" && id == "skripsi"){ 
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Nim Harus Di isi</div>");
        }else if($("#nama1").val() == "" && id == "skripsi"){
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Nama Harus Di isi</div>");
        }else if($("#tgl1").val() == "" && id == "skripsi"){
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Tanggal Harus Di isi</div>");
        }else if($("#konsentrasi1").val() == "0" && id == "skripsi"){ 
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Konsentrasi Harus Di Pilih</div>");
        }else if($("#bimbing1").val() == "0" && id == "skripsi"){
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Pembimbing 1 Harus Di Pilih</div>");
        }else if($("#instansi1").val() == "0" && id == "skripsi"){
            $("#pesan").html("<div class='alert alert-danger' role='alert'>Kolom Pembimbing Instansi Harus DI isi</div>");
        }else if($("#bimbing1").val() == "0" && id == "skripsi"){
            $("#kota1").html("<div class='alert alert-danger' role='alert'>Kolom Pembimbing Kota Harus Di isi</div>");
        }else if($("#judul1").val() == "0" && id == "skripsi"){
            $("#kota1").html("<div class='alert alert-danger' role='alert'>Kolom Judul Kota Harus Di isi</div>");
        }else{
            $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
            $("#pesan").html("<div class='alert alert-success' role='alert'>Mohon Tunggu.. </div>");
            $.ajax({
                type: 'POST',
                url: '<?php echo $aksi; ?>'+url,
                data:$("#"+id+"").serialize(),
                success: function(data) {
                    if(data.status == 0){
                        $("#pesan").html("<div class='alert alert-success' role='alert'>"+data.msg+"</div>");
                        $('#tt').datagrid('load')
                        $("#"+id+"").trigger("reset");
                        $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                    }else{
                        $("#pesan").html("<div class='alert alert-danger' role='alert'>"+data.msg+"</div>");
                        $("#"+id+"").trigger("reset");
                        $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                    }
                },
                dataType:"json",
                error: function(x, t, m) {
                    if(t==="timeout") {
                        $("#pesan").html("<div class='alert alert-danger' role='alert'>Koneksi Lambat.. Cobalah Kembali!?</div>");
                        $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                    } else {
                        $("#pesan").html("<div class='alert alert-danger' role='alert'>"+t+"</div>");
                        $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                    }
                } 
            }); 
        }
    }
	
    function transdelete(where,url){
        var r = confirm("Yakin Akan Menghapus Data ?");
        if(r == true){
            $.ajax({
                type: 'POST',
                url: '<?php echo $aksi; ?>'+url,
                data:'username='+where,
                success: function(data) {
                    if(data.status == 0){
                        $("#pesan").html("<div class='alert alert-success' role='alert'>"+data.msg+"</div>");
                        $('#tt').datagrid('load');
                    }else{
                        $("#pesan").html("<div class='alert alert-danger' role='alert'>"+data.msg+"</div>");
                    }
                },
                dataType:"json",
                error: function(x, t, m) {
                    if(t==="timeout") {
                        $("#pesan").html("<div class='alert alert-danger' role='alert'>Koneksi Lambat.. Cobalah Kembali!?</div>");
                    } else {
                        $("#pesan").html("<div class='alert alert-danger' role='alert'>"+t+"</div>");
                    }
                } 
            });
        }	
    }
</script>
