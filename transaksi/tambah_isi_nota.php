<?php
include 'header.php';
//Ambil data
$query1 = $db->prepare("SELECT * FROM nota");
$query2 = $db->prepare("SELECT kd_brg, nm_brg, stok FROM barang");
//Jalankan perintah SQL
$query1->bindParam(":nip", $currentUser['nip']);
$query1->execute();
$query2->execute();
// Ambil semua data dan masukkan ke variable $data
$data1 = $query1->fetchAll();
$data2 = $query2->fetchAll();
if(isset($_POST['submit'])){
  // Simpan data yang di inputkan ke POST ke masing-masing variable dan convert semua tag HTML yang mungkin dimasukkan untuk mengindari XSS
  $no_nota  = htmlentities($_POST['no_nota']);
  $kd_brg   = htmlentities($_POST['kd_brg']);
  $hrg_beli = htmlentities($_POST['hrg_beli']);
  $jml_msk  = htmlentities($_POST['jml_msk']);
  // Mengambil jumlah stok
  $ambil = $db->prepare("SELECT `stok` FROM `barang` WHERE `kd_brg` = :kd_brg");
  $ambil->bindParam(":kd_brg", $kd_brg);
  $ambil->execute();
  $data3 = $ambil->fetch();
  $stok  = $data3['stok'];
  // Prepared statement untuk menambah data
  $query = $db->prepare("INSERT INTO `isi_nota`(`kd_brg`, `no_nota`, `hrg_beli`, `jml_msk`) VALUES (:kd_brg, :no_nota, :hrg_beli, :jml_msk)");
  $query->bindParam(":no_nota", $no_nota);
  $query->bindParam(":kd_brg", $kd_brg);
  $query->bindParam(":hrg_beli", $hrg_beli);
  $query->bindParam(":jml_msk", $jml_msk);
  // Menambah jumlah stok
  $stok   = $stok + $jml_msk;
  $query2 = $db->prepare("UPDATE `barang` SET `stok` = :stok WHERE `kd_brg` = :kd_brg");
  $query2->bindParam(":stok", $stok);
  $query2->bindParam(":kd_brg", $kd_brg);
  // Jalankan perintah SQL
  $query->execute();
  $query2->execute();
    // Alihkan ke index.php
    header("location: isi_nota.php");
}
?>
  <!-- Let side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li>
          <a href="../index.php">
            <i class="fa fa-home"></i>
            <span>Beranda</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../master/staf.php">
                <i class="fa fa-users fa-fw"></i> Staf
              </a>
            </li>
            <li>
              <a href="../master/barang.php">
                <i class="fa fa-archive fa-fw"></i> Barang
              </a>
            </li>
            <li>
              <a href="../master/supplier.php">
                <i class="fa fa-building fa-fw"></i> Supplier
              </a>
            </li>
          </ul>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../transaksi/sp.php">
                <i class="fa fa-envelope fa-fw"></i> Surat Pesan
              </a>
            </li>
            <li>
              <a href="../transaksi/isi_sp.php">
                <i class="fa fa-pencil-square-o fa-fw"></i> Isi Surat Pesan
              </a>
            </li>
            <li>
              <a href="../transaksi/nota.php">
                <i class="fa fa-reply fa-fw"></i> Nota
              </a>
            </li>
            <li class="active">
              <a href="../transaksi/isi_nota.php">
                <i class="fa fa-list fa-fw"></i> Isi Nota
              </a>
            </li>
            <li>
              <a href="../transaksi/brg_klr.php">
                <i class="fa fa-shopping-cart fa-fw"></i> Barang Keluar
              </a>
            </li>
            <li>
              <a href="../transaksi/isi_brg_klr.php">
                <i class="fa fa-cart-plus fa-fw"></i> Isi Barang Keluar
              </a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../laporan/lap_barang_keluar.php">
                <i class="fa fa-file fa-fw"></i> Laporan Barang Keluar
              </a>
            </li>
            <li>
              <a href="../laporan/lap_barang_masuk.php">
                <i class="fa fa-file-text fa-fw"></i> Laporan Barang Masuk
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Isi Nota
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Isi Nota</h3>
            </div>
            <!-- /.box-header -->
            <form method=post>
              <div class="box-body">
                <div class="form-group">
                  <label for="no_nota">Nomor dan Tanggal Nota</label>
                  <!-- Perulangan Untuk Menampilkan Semua Data yang ada di Variable Data -->
                  <select class="form-control select2" style="width: 100%;" name="no_nota" id="no_nota" required="">
                    <option value=""> </option>
                    <?php foreach ($data1 as $value): ?>
                      <option value="<?php echo $value['no_nota'] ?>"><?php echo $value['no_nota'] ?> - <?php echo $value['tgl_nota'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="kd_brg">Kode Barang dan Nama Barang</label>
                  <!-- Perulangan Untuk Menampilkan Semua Data yang ada di Variable Data -->
                  <select class="form-control select2" style="width: 100%;" name="kd_brg" id="kd_brg" required="">
                    <option value=""> </option>
                    <?php foreach ($data2 as $value): ?>
                      <option value="<?php echo $value['kd_brg'] ?>"><?php echo $value['kd_brg'] ?> - <?php echo $value['nm_brg']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="hrg_beli">Harga Beli</label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="number" name="hrg_beli" id="hrg_beli" class="form-control" value="" required="">
                    <span class="input-group-addon">,00</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jml_msk">Jumlah Masuk</label>
                  <input type="number" name="jml_msk" id="jml_msk" class="form-control" value="" required="">
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat" name="submit"><i class="fa fa-plus-circle"></i> Tambah</button>
                <button type="reset" class="btn btn-default btn-flat" name="reset"><i class="fa fa-repeat"></i> Batal</button>
              </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'footer.php'; ?>
