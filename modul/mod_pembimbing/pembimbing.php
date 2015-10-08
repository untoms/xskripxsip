<?php
$aksi = "detail_";
include "config/fungsi_combobox.php";
?> 
<div id="pesan">
</div>
<div id="grid">
    <div id="tb">  
        <div class="navbar-form navbar" >
            <div class="form-group">
                <select id="sortby"  class="form-control">
                    <option value="nomor"> Nomer </option>
                    <option value="Nama"> Nama </option>
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
    <table id="tt" class="easyui-datagrid" style="height: 400px; width: 100%;" url="<?php echo $aksi; ?>" title="Daftar Detail Skripsi" rownumbers="true" toolbar="#tb" pagination="true">
        <thead data-options="frozen:true">
            <tr>
                <th field="nomor" width="150" sortable="true">Nomor</th>
                <th field="nama" width="200" sortable="true">Nama</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th field="nim" width="150" sortable="true">Nim</th>
                <th field="judul" width="300" sortable="true">judul</th>
                <th field="tgl" width="150" sortable="true">Tanggal Daftar</th>
                <th field="pbnama1" width="200" sortable="true">Pembimbing 1</th>
                <th field="pbnama2" width="200" sortable="true">Pembimbing 2</th>
                <th field="status" width="100" sortable="true">Status</th>
                <th field="1" width="100" sortable="true">Bab 1</th>
                <th field="2" width="100" sortable="true">Bab 2</th>
                <th field="3" width="100" sortable="true">Bab 3</th>
                <th field="4" width="100" sortable="true">Bab 4</th>
                <th field="5" width="100" sortable="true">Bab 5</th>
                <th field="tglujian" width="150" sortable="true">Tanggal Ujian</th>
                <th field="penguji1" width="200" sortable="true">Penguji 1</th>
                <th field="penguji2" width="200" sortable="true">Penguji 2</th>
                <th field="penguji3" width="200" sortable="true">Penguji 3</th>

            </tr>
        </thead>         
    </table>
</div> 

<script type="text/javascript">
    function cari(){
        $('#tt').datagrid('load',{
            data: $('#find').val(),
            sortby: $('#sortby').val(),
            cari:'1'
        });
    }


    function getData(where,url){
        $(".media").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo $aksi; ?>'+url,
            data:'name='+where,
            success: function(data) {
                $("#edit").trigger("reset");
                $('#NAMAINSTANSI').val(data.NAMAINSTANSI);
                $('#drkpd').val(data.drkpd);
                $('#NAMABERKAS').val(data.NAMABERKAS);
                $('#PERIHAL').val(data.PERIHAL);
                $('#NO').val(data.NO);
                $('#ISI').html(data.ISI);
                $('#NOSURAT').val(data.NOSURAT);
                $('#CATATAN').val(data.CATATAN);
                $('#WILAYAH').val(data.WILAYAH);
                $('#image').attr("src","image/"+data.TDT);
                if(data.TDT !="" ){
                    $(".media").show();
                }
                //$('#jenis_surat').html(data.JENISSURAT);
                /* tanggal */
                $('#tglterima').html(data.tgl_masuk);
                $('#tglsurat').html(data.tgl_surat);
                $('#tgldteruskan').html(data.tgl_terus);
                $('#tglbalas').html(data.tgl_balas);
                /* Combo */
                $('#tmptberkas').html(data.TMPTBERKAS);	
                $('#tkperkembangan').html(data.TK_PERKEMBANGAN);
                $('#sifatsurat').html(data.SIFAT_SURAT);
                $('#balas').html(data.BALAS);
                $('#namaup').html(data.NAMAUP);	
            },
            dataType:"json",
            error: function(x, t, m) {
                if(t==="timeout") {
                    $.messager.alert('Message', "Koneksi Lambat.. Cobalah Kembali!?", 'warning');
                } else {
                    $.messager.alert('Message', t, 'warning');
                }
            } 
        });
    }
    function trans(url,id){
        $.ajax({
            type: 'POST',
            url: '<?php echo $aksi; ?>'+url,
            data:$("#"+id+"").serialize(),
            success: function(data) {
                if(data.status == 0){
                    $("#pesan").html("<div class='alert alert-success' role='alert'>"+data.msg+"</div>");
                    $('#tt').datagrid('load')
                    $("#"+id+"").trigger("reset");
                }else{
                    $("#pesan").html("<div class='alert alert-danger' role='alert'>"+data.msg+"</div>");
                    $("#"+id+"").trigger("reset");
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
