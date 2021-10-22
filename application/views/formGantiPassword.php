<!--<div class="container">
  Outer Row
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body 
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900">Change your password for</h1>
                  <h5 class="mb-4"><?= $this->session->userdata('reset_email'); ?></h5>
                </div>
                <?= $this->session->flashdata('message'); ?>
                <form class="" method="post" action="<?= base_url('welcome/changepassword'); ?>">
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter new password...">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat password...">
                    <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Change Password
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>-->


<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  </div>
  <div class="card" style="width: 50%;">
    <div class="card-body">
      <form action="<?= base_url('welcome/gantiPasswordAksi'); ?>" method="post">
        <div class="form-group">
          <label for="">Password Baru1</label>
          <input type="password" name="passBaru" class="form-control">
          <?= form_error('passBaru', '<div class="text-small text-danger">', '</div>') ?>
        </div>
        <div class="form-group">
          <label for="">Ulangi Password Baru2</label>
          <input type="password" name="ulangPass" class="form-control">
          <?= form_error('ulangPass', '<div class="text-small text-danger">', '</div>') ?>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
      </form>
    </div>
  </div>
</div>