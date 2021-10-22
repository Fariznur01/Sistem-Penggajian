<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  </div>

  <div class="alert alert-success font-weight-bold mb-4" style="width:65%;">
    Selamat datang, Anda login sebagai pegawai
  </div>
  <div class="card" style="margin-bottom: 120px; width: auto;">
    <div class="card-header font-weight-bold bg-primary text-white">
      Data Pegawai
    </div>
    <?php foreach ($pegawai as $p) : ?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <img style="width: 32rem" src="<?= base_url('assets/photo/' . $p->photo); ?>" alt="">
          </div>
          <div class="col-md-7">
            <table class="table">
              <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $p->nip; ?></td>
              </tr>
              <tr>
                <td>Nama Pegawai</td>
                <td>:</td>
                <td><?= $p->nama_pegawai; ?></td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $p->jabatan; ?></td>
              </tr>
              <tr>
                <td>Tanggal Masuk</td>
                <td>:</td>
                <td><?= $p->tanggal_masuk; ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td><?= $p->status; ?></td>
              </tr>
              <tr>
                <td>No Hp</td>
                <td>:</td>
                <td><?= $p->no_hp; ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><?= $p->email; ?></td>
              </tr>
              <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $p->pendidikan; ?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $p->alamat; ?></td>
              </tr>
              <tr>
                <td>Peta</td>
                <td>:</td>
                <td>
                  <div class="mapouter">
                    <div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" src="<?= $p->peta; ?>
                                        " frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br>
                      <style>
                        .mapouter {
                          position: relative;
                          text-align: right;
                          height: 150px;
                          width: 400px;
                        }
                      </style><a href="https://www.embedgooglemap.net">google maps embed iframe generator</a>
                      <style>
                        .gmap_canvas {
                          overflow: hidden;
                          background: none !important;
                          height: 150px;
                          width: 400px;
                        }
                      </style>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>