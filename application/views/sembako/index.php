<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/datatable.php'); ?>
<div class="flash-data" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">SEMBAKO</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
                    <li class="breadcrumb-item">Sembako</li>
                    <!-- <li class="breadcrumb-item active">Starter Page</li> -->
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

                <div class="card">

                    <div class="card-body table-responsive">
                        <a href="<?= base_url('sembako/tambah') ?>" class="btn btn-primary  mb-3">Tambah Sembako</a>
                        <table id="example" class="mt-2 table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ACTION</th>
                                    <th>QTY</th>
                                    <th>NAMA SEMBAKO</th>
                                    <th>NAMA AGEN</th>
                                    <th>JENIS SEMBAKO</th>
                                    <th>TIPE SEMBAKO</th>
                                    <th>HARGA MODAL</th>
                                    <th>HARGA JUAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($tabel as $data) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="<?= base_url('sembako/edit/' . $data->id) ?>"><span
                                                class="btn btn-primary">Edit</span></a>
                                        <a href="<?= base_url('sembako/tambah_stok/' . $data->id) ?>"
                                            class="btn btn-success"><i class="fa fa-plus-circle"></i> / <i
                                                class="fa fa-minus-circle"></i> </a>
                                        <!-- <a href="<?= base_url('sembako/hapus/' . $data->id) ?>"
                                            class="btn btn-danger tombol-hapus">Hapus</a> -->

                                    </td>
                                    <td>
                                        <?php if ($data->stok == 0) {
                                                $stok = 0;
                                            } else {
                                                $stok = $data->stok;
                                            } ?>
                                        <?= $stok ?>
                                    </td>
                                    <td><?= $data->nama_sembako ?></td>
                                    <td><?= $data->nama_agen ?></td>
                                    <td><?= $data->jenis_sembako ?></td>
                                    <td><?= $data->tipe_sembako ?></td>
                                    <td><?= uang($data->harga_modal) ?></td>
                                    <td><?= uang($data->harga_jual) ?></td>

                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>




        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<script>
$(document).ready(function() {
    $('#example').DataTable({});

    $('.tombol-hapus').on('click', function(e) {
        e.preventDefault();

        const href = $(this).attr('href');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data Obat akan dihapus!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Data!'
        }).then((result) => {
            if (result.value == true) {
                document.location.href = href;
            }
        })
    })

    const flashData = $('.flash-data').data('flashdata');
    if (flashData) {
        if (flashData) {
            Swal.fire(
                flashData, '',
                'success'
            )
        }
    }
})
</script>
<?php $this->load->view('template/footer'); ?>