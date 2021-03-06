<?php
include 'header.php';
//Ambil data
$query = $db->prepare("SELECT MAX(`kd_brg`) AS palingGede FROM `barang");
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
  $nm_brg  = htmlentities($_POST['nm_brg']);
  $jenis   = htmlentities($_POST['jenis']);
  $satuan  = htmlentities($_POST['satuan']);
  $hrg_brg = htmlentities($_POST['hrg_brg']);
  $stok    = htmlentities($_POST['stok']);
  // Prepared statement untuk menambah data
  $query = $db->prepare("INSERT INTO `barang`(`kd_brg`, `nm_brg`, `jenis`, `satuan`, `hrg_brg`, `stok`) VALUES (:kd_brg, :nm_brg, :jenis, :satuan, :hrg_brg, :stok)");
  $query->bindParam(":kd_brg", $kode);
  $query->bindParam(":nm_brg", $nm_brg);
  $query->bindParam(":jenis", $jenis);
  $query->bindParam(":satuan", $satuan);
  $query->bindParam(":hrg_brg", $hrg_brg);
  $query->bindParam(":stok", $stok);
  // Jalankan perintah SQL
  $query->execute();
  // Alihkan ke index.php
  header("location: barang.php");
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
            <li class="active">
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
        Barang
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Barang</h3>
            </div>
            <!-- /.box-header -->
            <form method=post>
              <div class="box-body">
                <div class="form-group">
                  <label for="nm_brg">Kode Barang</label>
                  <input type="text" name="kd_brg" id="kd_brg" class="form-control" value="<?php echo $kode ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="nm_brg">Nama Barang</label>
                  <input type="text" name="nm_brg" id="nm_brg" class="form-control" value="" required="">
                </div>
                <div class="form-group">
                  <label for="jenis">Jenis Barang</label>
                  <select class="form-control select2" style="width: 100%;" name="jenis" id="jenis" required="">
                    <option value=""> </option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Case">Case</option>
                    <option value="Charger">Charger</option>
                    <option value="Headset">Headset</option>
                    <option value="Kabel Data">Kabel Data</option>
                    <option value="Power Bank">Power Bank</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="satuan">Satuan Barang</label>
                  <input type="text" name="satuan" id="satuan" class="form-control" value="" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 96 && event.charCode <= 122) || (event.charCode >= 32 && event.charCode <= 32)" required="">
                </div>
                <div class="form-group">
                  <label for="hrg_brg">Harga Barang</label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="number" name="hrg_brg" id="hrg_brg" class="form-control" value="" required="">
                    <span class="input-group-addon">,00</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="satuan">Stok Barang</label>
                  <input type="number" name="stok" id="stok" class="form-control" value="" required="">
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
