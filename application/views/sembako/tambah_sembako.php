<?php $this->load->view('template/header.php'); ?>
<!-- Page Heading -->
<!-- <h1 class="h3 mb-4 text-gray-800">Keluar / Masuk Sembako</h1> -->
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Keluar / Masuk Sembako</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('sembako') ?>">Sembako</a></li>
                    <li class="breadcrumb-item">Keluar / Masuk Sembako</li>
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
                                            class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>STOK</label>
                                        <input type="number" value="<?= $row->stok == null ? '0' : $row->stok; ?>"
                                            name="stok" class="stok form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>QTY</label>
                                        <input type="number" name="qty" class="form-control qty">
                                    </div>

                                    <div class="form-group">
                                        <label>JENIS</label> <label class="text-xs">(sembako masuk atau sembako
                                            keluar)</label>
                                        <select class="form-control" name="jenis" class="jenis">
                                            <option value="masuk">SEMBAKO MASUK</option>
                                            <option value="keluar">SEMBAKO KELUAR</option>
                                        </select>
                                    </div>

                                    <div class="formm-group">
                                        <label>NOTE</label>
                                        <textarea class="form-control" name="note" rows="3"></textarea>
                                    </div>
                                    <br>



                                    <button type="submit"
                                        class="float-right btn btn-success text-white simpan">Simpan</button>
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
            qty: {
                required: true,
                number: true,
            },
        }
    });

});
</script>


<?php $this->load->view('template/footer.php'); ?>