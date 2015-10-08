<?php
$aksi = "users_";
?> 
<div id="pesan">
</div>
<div id="grid">
    <div id="tb"> 
        <div class="navbar-form navbar" >
            <div class="form-group">	
                <select id="sortby" class="form-control">
                    <option value="username"> Username </option>
                    <option value="nama_lengkap"> Nama </option>
                </select>
            </div>
            <div class="form-group">
                <input id="mapel" class="form-control" onkeyup="cari_user()"/>
            </div>
            <!--<input type=button value='Tambah User' onclick="window.location.href='?module=user&act=tambahuser'"/> -->
            <div class="form-group">
                <?php if ($_SESSION['leveluser'] == "admin") { ?>
                    <button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#tambah" >Tambah User</button>
                    <button type="button" class="btn btn-default navbar-btn" onclick = "trans('?module=user&act=proses','update')" >Proses User</button>
                    <button type="button" class="btn btn-default navbar-btn" onclick = " transdelete('','?module=user&act=hapus')" >Reset User</button>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <table id="tt" class="easyui-datagrid" style="height: 400px; width: 100%;" url="<?php echo $aksi . "?module=user&act=load"; ?>" title="Usernames" rownumbers="true" toolbar="#tb" pagination="true">
        <thead>
            <tr>
                <th field="nama" width="250" sortable="true">Nama Lengkap</th>
                <th field="username" width="150" sortable="true">Username</th>
                <th field="level" width="50" sortable="true">Level</th>
                <th field="telp" width="80" sortable="true">NO.Telpon</th>
                <th field="blokir" width="50" sortable="true">Status</th>
                <th field="aksi" width="50" sortable="true">Aksi</th>
            </tr>
        </thead>        
    </table>
</div> 

<div class="modal fade" id = "tambah">
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
                <h4 class="modal-title">Tambah Pesan</h4>
            </div>
            <div class="modal-body">
                <form id ="input">
                    <div class="form-group">
                        <input type = "text" class="form-control" autocomplete = "off" requaired name="username" placeholder="Username" />
                    </div>
                    <div class="form-group">	
                        <input type = "password" class="form-control" autocomplete = "off" name="password" placeholder="Password" />
                    </div>
                    <div class="form-group">	
                        <input type = "text" class="form-control" autocomplete = "off" name="nama_lengkap" placeholder="Nama Lengkap" />
                    </div>
                    <div class="form-group">	
                        <input type = "text" class="form-control" autocomplete = "off" name="nik" placeholder="NIK" />
                    </div>    
                    <div class="form-group">	
                        <input type = "email" class="form-control" autocomplete = "off" name="email"  placeholder="Email" />
                    </div>
                    <div class="form-group">	
                        <input type = "tel" class="form-control" autocomplete = "off" name="no_telp"  placeholder="No Telp" />
                    </div>
                    <div class="form-group">
                        <select id='status' name ='status' class="form-control">
                            <option value=''>Pilih Level</option>
                            <option value='admin'>Admin</option>
                            <option value='guest'>Mahasiswa</option>
                            <option value='dosen'>Dosen</option>
                        </select>
                    </div>
                </form>
            </div>	
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "trans('?module=user&act=input','input')">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id = "edit">
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
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div class="modal-body">
                <form id ="update">
                    <div class="form-group">
                        <input type = "text" readonly class="form-control" autocomplete = "off" name="username" id="eusername" placeholder="Username" />
                    </div>
                    <div class="form-group">	
                        <input type = "password" class="form-control" autocomplete = "off" name="password" id="epassword" placeholder="Password" />
                    </div>
                    <div class="form-group">	
                        <input type = "text" class="form-control" autocomplete = "off" name="nama_lengkap" id="enama_lengkap" placeholder="Nama Lengkap" />
                    </div>
                    <div class="form-group">	
                        <input type = "text" class="form-control" autocomplete = "off" name="nik" id="enik" placeholder="NIK" />
                    </div> 
                    <div class="form-group">	
                        <input type = "text" class="form-control" autocomplete = "off" name="email"  id="eemail" placeholder="Email" />
                    </div>
                    <div class="form-group">	
                        <input type = "text" class="form-control" autocomplete = "off" name="no_telp" id="eno_telp"  placeholder="No Telp" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "trans('?module=user&act=update','update')">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="wait"></div> 
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/easyui/easyloader.js"></script>
<script type="text/javascript" src="js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="js/easyui/jquery.min.js"></script>
<script type="text/javascript">
    function pilih_kelas(){
        var level = $("#status").val();
        if(level == 'wali'){
            $("#kelas").removeAttr("disabled","");
        }else{
            $("#kelas").attr("disabled","");
        }
    }
    function cari_user(){
        $('#tt').datagrid('load',{
            data: $('#mapel').val(),
            sortby: $('#sortby').val(),
            cari:'1'
        });
    }
    var ddmenuitem	= 0;

    // open hidden layer
    function mopen(id)
    {	
        // cancel close timer
        mcancelclosetime();

        // close old layer
        if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

        // get new layer and show it
        ddmenuitem = document.getElementById(id);
        ddmenuitem.style.visibility = 'visible';

    }
    function mclose()
    {
        if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
    }
    function getData(where,url){
        $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
        $.ajax({
            type: 'POST',
            url: '<?php echo $aksi; ?>'+url,
            data:'name='+where,
            success: function(data) {
                $('#eusername').val(data.username);
                $('#enama_lengkap').val(data.nama_lengkap);
                $('#eemail').val(data.email);
                $('#enik').val(data.enik);
                $('#eno_telp').val(data.no_telp);
                $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
            },
            dataType:"json",
            error: function(x, t, m) {
                if(t==="timeout") {
                    $.messager.alert('Message', "Koneksi Lambat.. Cobalah Kembali!?", 'warning');
                    $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                } else {
                    $.messager.alert('Message', t, 'warning');
                    $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                }
            } 
        });
    }
    function trans(url,id){
        $("#pesan").html("<div class='alert alert-success' role='alert'>Mohon Tunggu.. </div>");
        $("#wait").attr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
        $.ajax({
            type: 'POST',
            url: '<?php echo $aksi; ?>'+url,
            data:$("#"+id+"").serialize(),
            success: function(data) {
                if(data.status == 0){
                    $("#pesan").html("<div class='alert alert-success' role='alert'>"+data.msg+"</div>");
                    $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                    $('#tt').datagrid('load')
                    $("#"+id+"").trigger("reset");
                }else{
                    $("#pesan").html("<div class='alert alert-danger' role='alert'>"+data.msg+"</div>");
                    $("#wait").removeAttr("style","position: fixed;top: 0;left: 0;right: 0;height: 100%;opacity: 0.4;filter: alpha(opacity=40); background-color: #000;");
                    $('#tt').datagrid('load')
                    $("#"+id+"").trigger("reset");
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
