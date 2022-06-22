<?php $this->load->view('template/header.php'); ?>
<!-- Page Heading -->
<!-- <h1 class="h3 mb-4 text-gray-800"><?= $page ?> Sembako</h1> -->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Data Sembako</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('sembako') ?>">Sembako</a></li>
                    <li class="breadcrumb-item">Tambah Data Sembako</li>
                    <!-- <li class="breadcrumb-item active">Keluar / Masuk Sembako</li> -->
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->



    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">


                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form method="post" id="myForm" action="<?= base_url('sembako/process') ?>">
                                    <input type="hidden" name="id" value="<?= $row->id ?>">
                                    <input type="hidden" name="opsi" value="<?= $page ?>">
                                    <div class="form-group">
                                        <label>Nama Sembako</label>
                                        <input type="text" name="nama_sembako" value="<?= $row->nama_sembako ?>"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Sembako</label>
                                        <input type="text" name="jenis_sembako" value="<?= $row->jenis_sembako ?>"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Tipe Sembako</label>
                                        <input type="text" name="tipe_sembako" value="<?= $row->tipe_sembako ?>"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Agen</label>
                                        <input type="text" name="nama_agen" value="<?= $row->nama_agen ?>"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Harga Jual</label>
                                        <input type="number" name="harga_jual" value="<?= $row->harga_jual ?>"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Modal</label>
                                        <input type="number" name="harga_modal" value="<?= $row->harga_modal ?>"
                                            class="form-control">
                                    </div>



                                    <button type="submit" class="float-right btn btn-success text-white">Simpan</button>
                                    <button type="reset"
                                        class="float-right btn btn-primary text-white mr-2">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    $('#myForm').validate({ // initialize the plugin
        rules: {
            harga_jual: {
                required: true,
                number: true,
                minlength: 4,
            },
            harga_modal: {
                required: true,
                number: true,
                // minlength: 5,
            },
            nama_sembako: {
                required: true,
            },
            nama_agen: {
                required: true,
            },
            jenis_sembako: {
                required: true,
            },
            tipe_sembako: {
                required: true,
            },

        }
    });

});
</script>


<?php $this->load->view('template/footer.php'); ?>