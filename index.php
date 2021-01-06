<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "arkademy";

    $koneksi = mysqli_connect($server, $user, $password, $database)or die(mysqli_error($koneksi));

    //If Input Button Clicked
    if(isset($_POST['btnsimpan'])) {

        //pengujian apakah data diedit atau disimpan baru
        if($_GET['hal'] == "edit") {
            $edit = mysqli_query($koneksi, "UPDATE produk set
                                            nama_produk = '$_POST[namaproduk]',
                                            keterangan = '$_POST[keterangan]',
                                            harga = '$_POST[harga]',
                                            jumlah = '$_POST[jumlah]'
                                        WHERE id = '$_GET[id]'
                                            ");
        if($edit) {
            echo"<script>alert('Edit Data Sukses');
                    document.location='index.php';</script>";
        } else {
            echo"<script>alert('Edit Data gagal')
                    document.location='index.php';</script>";
        }


    } else {
        $simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah)VALUES ('$_POST[namaproduk]',
                                        '$_POST[keterangan]',
                                        '$_POST[harga]',
                                        '$_POST[jumlah]')
                                        ");
    if($simpan) {
        echo"<script>alert('Data Berhasil Disimpan');
                    document.location='index.php';</script>";
    } else {
         echo"<script>alert('Data Gagal Disimpan')
                  document.location='index.php';</script>";
     }
    }


        
    }

    // validasi edit / delete
    if(isset($_GET['hal'])) {
        if($_GET['hal'] == "edit") {
            $tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if ($data) {
                $vnama = $data['nama_produk'];
                $vketerangan = $data['keterangan'];
                $vharga = $data['harga'];
                $vjumlah = $data['jumlah'];
            }
        } else if ($_GET['hal'] == 'hapus') {
            $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$_GET[id]'");
            if($hapus) {
                echo"<script>alert('Data Berhasil Dihapus');
                    document.location='index.php';</script>";
            } else {
                echo"<script>alert('Data Gagal Dihapus');
                    document.location='index.php';</script>";
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD produk</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">CRUD Produk Penjualan</h1>

        <!-- FORM INPUT PRODUK -->
        <div class="card mt-5">
            <div class="card-header bg-success text-white">
                Form Input Produk
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label class="mb-2">Nama Produk</label>
                        <input type="text" name="namaproduk" value ="<?=@$vnama?>" class="form-control mb-3" placeholder="Input Nama Produk">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Keterangan</label>
                        <textarea name="keterangan" class="form-control" placeholder="Masukkan Alamat"><?=@$vketerangan?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Harga</label>
                        <input type="number" name="harga" value ="<?=@$vharga?>" class="form-control mb-3" placeholder="Masukkan Harga">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Jumlah</label>
                        <input type="number" name="jumlah" value ="<?=@$vjumlah?>" class="form-control mb-3" placeholder="Masukkan Jumlah">
                    </div>
                    <button type="submit" class="btn btn-success" name="btnsimpan">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="btnreset">Kosongkan</button>
                </form>
            </div>
        </div>
        <!-- FORM INPUT PRODUK -->

        <!-- TABEL DATA-->
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                Tabel Data Produk
            </div>
            <div class="card-body">
                <table class="table rable-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Opsi</th>
                    </tr>
                    <?php
                    $no=1;
                        $tampil = mysqli_query($koneksi, "SELECT * FROM produk order by id desc");
                        while($data = mysqli_fetch_array($tampil)) :
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$data['nama_produk']?></td>
                        <td><?=$data['keterangan']?></td>
                        <td><?=$data['harga']?></td>
                        <td><?=$data['jumlah']?></td>
                        <td>
                            <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?hal=hapus&id=<?=$data['id']?>"  onclick="return confirm('Apakah Yakin Ingin Menghapus Data Ini ?')" class="btn btn-danger">hapus</a>
                        </td>
                    </tr>
                    <?php endwhile ?>
                </table>
            </div>
        </div>


        <!-- TABEL DATA-->


    </div>

<script src="js/bootstrap.min.js"></script>
</body>
</html>