<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <div class="card" style="margin-bottom: 120px; width: 61%;">
        <div class="card-header font-weight-bold bg-primary text-white ">
            Data Pegawai
        </div>
        <?php $no = 0;
        foreach ($pegawai as $p) : ?>
            <div class="card-body">
                <div class="row">
                    <!-- <div class=" col-md-5">
                                <img style="width:30rem" src="<?= base_url('assets/photo/' . $p->photo); ?>" alt="">
                        </div> -->
                    <div class="col-md-7">
                        <table class="table">
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
                                        <div class="gmap_canvas"><iframe width="auto" height="auto" id="gmap_canvas" src="<?= $p->peta; ?>
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
                                                    width: 300px;
                                                }
                                            </style>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <a class="mb-2 mt-2 btn btn-sm btn-danger" href="<?= base_url('admin/dataPegawai'); ?>"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>