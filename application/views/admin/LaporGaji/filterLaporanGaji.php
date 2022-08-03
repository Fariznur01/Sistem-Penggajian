<!-- Begin Page Content -->
<div class="container-fluid" style="margin-bottom: 100px;">
  <div class=" card mx-auto" style="width: 55%;">
    <div class="card-header bg-primary text-white text-center">
      Filter Laporan Gaji Pegawai
    </div>
    <form action="<?= base_url('admin/laporanGaji/cetakLaporanGaji'); ?>" target="blank" method="post">
      <div class="card-body">
        <div class="form-group row">
          <!--Kalender-->
          <div class="container mt-2  " align="left">
            <div class="card" style="width:33rem">
              <div class="card-header">
                Kalender
              </div>
              <div class="card-body">
                <?php echo $kalender ?>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-print"></i> Cetak Laporan Gaji</button>

        </div>
    </form>

    <!--Email -->

  </div>
</div>