<!-- Begin Page Content -->
<div class="container-fluid" style="margin-bottom: 100px;">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  </div>
  <?= $this->session->flashdata('pesan'); ?>
  <!--menambah data -->
  <a class="mb-2 mt-2 btn btn-sm btn-success" href="<?= base_url('admin/dataPegawai/tambahData'); ?>"><i class="fas fa-plus"></i> Tambah Pegawai</a>
  <!-- mencari data -->
  <div class="navbar-form navbar-right mt-3 mb-3">
    <?php echo form_open('admin/datapegawai/search') ?>
    <input type="text" name="keyword" class="form-control" placeholder="Search">
    <button type="submit" class="btn btn-success mt-2">Cari Nama </button>
    <?php echo form_close(); ?>
  </div>
  <table class="table table-striped table-bordered ">
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">NIP</th>
      <th class="text-center">Nama Pegawai</th>
      <th class="text-center">Jenis Kelamin</th>
      <th class="text-center">Jabatan</th>
      <th class="text-center">Foto</th>
      <th class="text-center">Status</th>
      <!--<th class="text-center">Photo</th>-->
      <th class="text-center">Hak Akses</th>
      <th class="text-center" width="150">Action</th>
    </tr>
    <?php $no = 1;
    foreach ($pegawai as $p) : ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $p->nip; ?></td>
        <td><?= $p->nama_pegawai; ?></td>
        <td><?= $p->jenis_kelamin; ?></td>
        <td><?= $p->jabatan; ?></td>
        <td><img src="<?= base_url('assets/photo/') . $p->photo; ?>" alt="" width="70px"></td>
        <td><?= $p->status; ?></td>
        <?php if ($p->hak_akses == 1) { ?>
          <td>Admin</td>
        <?php } elseif ($p->hak_akses == 2) { ?>
          <td>Pegawai</td>
        <?php } else { ?>
          <td>Tidak Ada</td>
        <?php } ?>

        <td>
          <a class="btn btn-sm btn-success" href="<?= base_url('admin/dataPegawai/detaildata/' . $p->id_pegawai); ?>"><i class="fas fa-info"></i></i></a>
          <a class="btn btn-sm btn-primary" href="<?= base_url('admin/dataPegawai/updateData/' . $p->id_pegawai); ?>"><i class="fas fa-edit"></i></a>
          <a onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger" href="<?= base_url('admin/dataPegawai/deleteData/' . $p->id_pegawai); ?>"><i class="fas fa-trash"></i></a>
          </center>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>