<?php
include_once("../helper/koneksi.php");
include_once("../helper/function.php");


$login = cekSession();
if ($login == 0) {
    redirect("login.php");
}

if (post("nama_group")) {
    $nama = post("nama_group");

    // $nomor = $_POST['target'];
    // $pesan = post("pesan"); 
    $u = $_SESSION['username'];

    $q = mysqli_query($koneksi, "INSERT INTO group_nomor(`nama_group`) VALUES('$nama')");
    // $nomor = serialize(getAllNumber());
    // if($nomor){
    //        $q = mysqli_query($koneksi, "INSERT INTO blest(`nomor`)
    // VALUES('$nomor')");
    // }


    if (isset($_POST['target'])) {
        $n = $_POST['target'];
    } else {
        $n = getAllNumber();
    }


    $id_group = getLastID("group_nomor");

    foreach ($n as $nn) {

        $q = mysqli_query($koneksi, "INSERT INTO detail_group(`id_group`, `id_nomor`)
            VALUES('$id_group','$nn')");

        if ($q) {
            toastr_set("success", "Group Berhasil di Buat");
        } else {
            toastr_set("error", "gagal Buat Group");
        }
    }
}

if (post("id_group_edit")) {

    $nama_group = post("nama_group_1");
    $id_group = post("id_group_edit");
    //  $q = mysqli_query($koneksi,"INSERT INTO group_nomor(`nama_group`) VALUES('$nama')");
    if (isset($_POST['target'])) {
        // $n = $_POST['target'];
        $n = $_POST['target'];
    } else {
        $n = getAllNumber();
    }



    if (isset($_POST['nama_group_1'])) {

        $q = mysqli_query($koneksi, "UPDATE group_nomor SET `nama_group` = '$nama_group' where `id` = '$id_group' ");
    }

    $del = mysqli_query($koneksi, "DELETE FROM detail_group Where id_group = '$id_group' ");

    foreach ($n as $nn) {


        $qi = mysqli_query($koneksi, "INSERT INTO detail_group(`id_group`,`id_nomor`) VALUES('$id_group','$nn')");
        if ($qi) {
            toastr_set("success", "Group Berhasil di Buat");
        } else {
            toastr_set("error", "gagal Buat Group");
        }
    }
}

if (get("act") == "hapus") {
    $id = get("id");

    $q = mysqli_query($koneksi, "DELETE FROM group_nomor WHERE id='$id'");
    $q2 = mysqli_query($koneksi, "DELETE FROM detail_group WHERE id_group='$id'");
    toastr_set("success", "Sukses hapus nomor");
    redirect("group_nomor.php");
}

if (get("act") == "delete_all") {
    $q = mysqli_query($koneksi, "DELETE FROM group_nomor");
    toastr_set("success", "Sukses hapus semua Group nomor");
    redirect("group_nomor.php");
}

require_once('../templates/header.php');
?>



<!-- Page Wrapper -->
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
        Tambah Group Nomor
    </button>

    <br>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="display: contents">Data Nomor</h6>
            <a class="btn btn-danger float-right" href="group_nomor.php?act=delete_all" style="margin:5px">Hapus Semua Group</a>
            <button type="button" class="btn btn-success float-right" data-toggle="modal" style="margin:5px" data-target="#import">
                Import Group Excel
            </button>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>


                            <th>Id Group</th>
                            <th>Nama Group</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION['level'] == "1") {
                            $q = mysqli_query($koneksi, "SELECT DISTINCT * FROM group_nomor");
                        }


                        while ($row = mysqli_fetch_assoc($q)) {

                            echo '<tr>';

                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['nama_group'] . '</td>';
                            echo '<td><a class="btn btn-danger" href="group_nomor.php?act=hapus&id=' . $row['id'] . '">Hapus</a>
                                                       <button type="button" class="btn btn-success detail" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#detail">
                                                            Detail
                                                    </button>
                                                        <button type="button" class="btn btn-primary edit" data-name="' . $row['nama_group'] . '" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#edit_group">
                        Edit
                    </button></td>';
                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <a href="https://wa.wikablast.com">wikablast</a></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Group Nomor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label> Nama Group </label>
                    <input type="text" name="nama_group" required class="form-control">
                    <br>
                    <label>Pilih Nomor</label>
                    <br>
                    <select class="form-control js-example-basic-multiple" name="target[]" multiple="multiple" style="width: 100%">
                        <?php
                        if ($_SESSION['level'] == "1") {
                            $q = mysqli_query($koneksi, "SELECT * FROM nomor");
                        } else {
                            $u = $_SESSION['username'];
                            $q = mysqli_query($koneksi, "SELECT * FROM nomor WHERE make_by='$u'");
                        }
                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nama'] . ' (' . $row['nomor'] . ')</option>';
                        }
                        ?>
                    </select>
                    <br>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Id Group</td>
                                    <td>Id Nomor</td>
                                    <td>Nomor</td>
                                    <td>Nama </td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody id="isi_tabel">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabela" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabela">Edit Group Nomor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">

                    <input type="hidden" readonly name="id_group_edit">
                    <br>
                    <label> Nama Group </label>
                    <input type="text" name="nama_group_1" class="form-control">
                    <br>
                    <label>Target Nomor</label>
                    <br>
                    <select class="form-control js-example-basic-multiple" name="target[]" multiple="multiple" style="width: 100%">
                        <?php
                        if ($_SESSION['level'] == "1") {
                            $q = mysqli_query($koneksi, "SELECT * FROM nomor");
                        } else {
                            $u = $_SESSION['username'];
                            $q = mysqli_query($koneksi, "SELECT * FROM nomor WHERE make_by='$u'");
                        }
                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nama'] . ' (' . $row['nomor'] . ')</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <br>
                    <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="pesan1" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Nomor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="helper/import_group_excel.php" method="POST" enctype="multipart/form-data">
                    <label> File (.xlsx) </label>
                    <input type="file" name="file" required class="form-control">
                    <br>
                    <label> Mulai dari Baris ke </label>
                    <input type="text" name="a" required class="form-control" value="2">
                    <br>
                    <label> Kolom Nama ke </label>
                    <input type="text" name="b" required class="form-control" value="1">
                    <br>
                    <label> Kolom Nomor ke </label>
                    <input type="text" name="c" required class="form-control" value="2">
                    <br>
                    <label> Kolom pesan ke </label>
                    <input type="text" name="d" required class="form-control" value="3">
                    <br>
                    <label> Kolom IdGroup ke </label>
                    <input type="text" name="e" required class="form-control" value="4">
                    <br>
                    <p> Download file contoh <a href="../excel/group_contoh.xlsx" target="_blank">disini</a> </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script>

</script>
<script>
    <?php

    toastr_show();

    ?>
</script>
<script>
    $(".detail").click(function(e) {
        e.preventDefault();
        var isi = $(this).attr('data-id');
        $("[name=id_groups]").val(isi);
        // $(this).attr('data-id');
        // var i = 'test';
        // $(".modal-body").html(isi);

        //               $('#myTable').DataTable({
        //                               "ajax" : {

        //     "method" : "POST",
        //     "url" : "get_detail_nomor.php",
        //     "data" : { id : isi },
        //     "success": function (result) {
        //           console.log(result.id_group);                      
        //     } 
        //   }  
        //                              });

        $.ajax({
            url: "ajax/get_detail_nomor.php",
            method: 'post',
            data: {
                id: isi
            },

            success: function(result) {
                console.log(result);
                // $(".modal-body").html(result);
                var html = '';

                var a = JSON.parse(result);

                for (let i = 0; i < a.length; i++) {

                    html += '<tr>' +
                        '<td>' + a[i].id_group + '</td>' +
                        '<td>' + a[i].id_nomor + '</td>' +
                        '<td>' + a[i].nomor + '</td>' +
                        '<td>' + a[i].nama + '</td>' +
                        '<td><a class="btn btn-danger btn-small hapus_nomor_group" idd="' + a[i].id_detail_group + '" ><span class="fa fa-trash"></span></a></td>' +
                        '</tr>';

                    $(".modal-body #isi_tabel").html(html);


                }

                $('#myTable').DataTable();
                $(".hapus_nomor_group").click(function() {

                    var id = $(this).attr('idd');
                    console.log(id);
                    $.ajax({
                        url: "ajax/delete_nomor_group.php",
                        method: "post",
                        data: {

                            id: id
                        },
                        success: function(result) {
                            alert('success terhapus');

                        }



                    })

                })


            }
        });


    })


    $(".edit").click(function(e) {
        e.preventDefault();

        var isi = $(this).attr('data-id');

        $("[name=id_group_edit]").val(isi);

        var name = $(this).attr('data-name');


        $("[name=nama_group_1]").val(name);
        // $(this).attr('data-id');
        // var i = 'test';
        // $(".modal-body").html(isi);

        //  $.ajax({ 
        //         url: "get_nomor.php",
        //         method:'post',
        //         data : {
        //             id:isi
        //         } ,

        //     success: function(result){

        //             // $(".modal-body").html(result);
        //             var html = '';

        //             var a = JSON.parse(result);

        //             for(let i = 0; i < a.length; i++){

        //                 html += '<tr>'+
        //                         '<td>'+a[i].id_group+'</td>'+
        //                         '<td>'+a[i].id_nomor+'</td>'+
        //                         '<td>'+a[i].nomor+'</td>'+
        //                         '<td>'+a[i].nama+'</td>'+
        //                         '</tr>';

        //                 $(".modal-body #isi_tabel").html(html);

        //             }


        // }});


    })
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            dropdownAutoWidth: true
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
</body>

</html>