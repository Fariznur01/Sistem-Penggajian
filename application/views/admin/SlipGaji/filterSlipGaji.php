<!-- Begin Page Content -->
<div class="container-fluid" style="margin-bottom: 100px;">
  <div class="card mx-auto" style="width: 55%;">
    <div class="card-header bg-primary text-white text-center">
      Filter Slip Gaji
    </div>
    <form action="<?= base_url('admin/slipGaji/cetakSlipGaji'); ?>" target=" blank" method="post">
      <div class="card-body">
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-3 col-form-label">Bulan</label>
          <div class="col-sm-9">
            <select name="bulan" id="" class="form-control">
              <option value="">--Pilih Bulan--</option>
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-3 col-form-label">Tahun</label>
          <div class="col-sm-9">
            <select name="tahun" id="" class="form-control">
              <option value="">--Pilih Tahun--</option>
              <?php
              $tahun = date('Y');
              for ($i = 2021; $i < $tahun + 5; $i++) { ?>
                <option value="<?= $i; ?>"><?= $i; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-3 col-form-label">Nama Pegawai</label>
          <div class="col-sm-9">
            <select name="nama_pegawai" id="" class="form-control">
              <option value="">--Pilih Pegawai--</option>
              <?php foreach ($pegawai as $p) : ?>
                <option value="<?= $p->nama_pegawai; ?>"><?= $p->nama_pegawai; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-print"></i> Cetak Slip Gaji</button>
          <!--Kalender-->
          <div class="container mt-5 mb-0  " align="left">
            <div class="card" style="width:33rem">
              <div class="card-header">
                Kalender
              </div>
              <div class="card-body">
                <?php echo $kalender ?>
              </div>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>