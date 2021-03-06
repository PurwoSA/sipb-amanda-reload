<?php
include 'header.php';
//Ambil data
$query = $db->prepare("SELECT MAX(`kd_supplier`) AS palingGede FROM `supplier");
//Jalankan perintah SQL
$query->execute();
if ($query->rowCount() == 0) {
  //Tidak ada hasil
  $kode = 1;
} else {
  // ID Ditemukan, Ambil data
  $data = $query->fetch();
  $kode = $data['palingGede'] + 1;
}
if(isset($_POST['submit'])){
  // Simpan data yang di inputkan ke POST ke masing-masing variable dan convert semua tag HTML yang mungkin dimasukkan untuk mengindari XSS
  $nm_supplier   = htmlentities($_POST['nm_supplier']);
  $almt_supplier = htmlentities($_POST['almt_supplier']);
  $telp_supplier = htmlentities($_POST['telp_supplier']);
  // Prepared statement untuk menambah data
  $query = $db->prepare("INSERT INTO `supplier`(`kd_supplier`, `nm_supplier`, `almt_supplier`, `telp_supplier`) VALUES (:kd_supplier, :nm_supplier, :almt_supplier, :telp_supplier)");
  $query->bindParam(":kd_supplier", $kode);
  $query->bindParam(":nm_supplier", $nm_supplier);
  $query->bindParam(":almt_supplier", $almt_supplier);
  $query->bindParam(":telp_supplier", $telp_supplier);
  // Jalankan perintah SQL
  $query->execute();
  // Alihkan ke index.php
  header("location: supplier.php");
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
        <li class="treeview active">
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
            <li class="active">
              <a href="../master/supplier.php">
                <i class="fa fa-building fa-fw"></i> Supplier
              </a>
            </li>
          </ul>
        </li>
        <li class="treeview">
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
            <li>
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
        Supplier
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Supplier</h3>
            </div>
            <!-- /.box-header -->
            <form method=post>
              <div class="box-body">
                <div class="form-group">
                  <label for="nm_supplier">Kode Supplier</label>
                  <input type="text" name="kd_supplier" id="kd_supplier" class="form-control" value="<?php echo $kode ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="nm_supplier">Nama Supplier</label>
                  <input type="text" name="nm_supplier" id="nm_supplier" class="form-control" value="">
                </div>
                <div class="form-group">
                  <label for="almt_supplier">Alamat Supplier</label>
                  <input type="text" name="almt_supplier" id="almt_supplier" class="form-control" value="">
                </div>
                <div class="form-group">
                  <label for="telp_supplier">Telepon Supplier</label>
                  <input type="text" name="telp_supplier" id="telp_supplier" class="form-control" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
