<?php $this->load->view('template/header.php'); ?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> -->
<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->

<?php $this->load->view('template/datatable.php'); ?>

<!-- Page Heading -->
<!-- <h1 class="h3 mb-4 text-gray-800">History Sembako</h1> -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">HISTORY SEMBAKO</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
                    <li class="breadcrumb-item">History Sembako</li>
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



                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">


                        <div class="table-responsive">
                            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sembako</th>
                                        <th>Jenis</th>
                                        <th>qty</th>
                                        <th>Note</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($tabel as $data) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->nama_sembako ?></td>
                                        <td><?= $data->jenis ?></td>
                                        <td><?= $data->qty ?></td>
                                        <td><?= $data->note ?></td>
                                        <td><?= $data->add_date ?></td>

                                    </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel'
        ]
    });


})
</script>



<?php $this->load->view('template/footer.php'); ?>