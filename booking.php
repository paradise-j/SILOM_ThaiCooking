<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
  session_start();
  require_once 'connect.php';


    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $db->query("DELETE FROM `savedata` WHERE `id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            // echo "<script>alert('Data has been deleted successfully');</script>";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ลบข้อมูลเรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=booking.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Booking Details</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- ---------------------------------------      AdddataModal ---------------------------------------------------------------------->
    <div class="modal fade" id="AddGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_BookingDetails.php" method="POST">
                        <div class="mb-1">
                            <label for="" class="col-form-label">Company name</label>
                            <select class="form-control" aria-label="Default select example" id="company" name="company" style="border-radius: 30px;" required>
                                <option selected disabled>please choose.......</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `company`");
                                    $stmt->execute();
                                    $coms = $stmt->fetchAll();
                                    
                                    foreach($coms as $com){
                                ?>
                                <option value="<?= $com['com_name']?>"><?= $com['com_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="" class="col-form-label">Datetime</label>
                            <input class="form-control" type="date" style="border-radius: 30px;" name="date" required> 
                        </div>
                        <div class="mb-1">
                            <label for="defaultInput" class="form-label">Name</label>
                            <input id="defaultInput" class="form-control" type="text" style="border-radius: 30px;" name="name" required>
                        </div>
                        <div class="mb-1">
                            <label for="defaultInput" class="form-label">Quantity</label>
                            <input id="defaultInput" class="form-control" type="number" style="border-radius: 30px;" name="quan" required>
                        </div>
                        <div class="mb-1">
                            <label for="defaultInput" class="form-label">Code</label>
                            <input id="defaultInput" class="form-control" type="text" style="border-radius: 30px;" name="code" required>
                        </div>
                        <div class="mb-1">
                            <label for="" class="col-form-label">Course</label>
                            <select class="form-control" aria-label="Default select example" id="course" name="course" style="border-radius: 30px;" required>
                                <option selected disabled>please choose.......</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `course`");
                                    $stmt->execute();
                                    $cous = $stmt->fetchAll();
                                    
                                    foreach($cous as $cou){
                                ?>
                                <option value="<?= $cou['course_name']?>"><?= $cou['course_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="" class="col-form-label">Session</label>
                            <select class="form-control" aria-label="Default select example" id="session" name="session" style="border-radius: 30px;" required>
                                <option selected disabled>please choose.......</option>
                                <option value="morning">morning</option>
                                <option value="afternoon">afternoon</option>
                                <option value="evening">evening</option>

                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="defaultInput" class="form-label">Price</label>
                            <input id="defaultInput" class="form-control" type="number" min="1" style="border-radius: 30px;" name="price" required>  
                        </div>
                        <div class="mb-1">
                            <label for="defaultInput" class="form-label">Teacher's name</label>
                            <input id="defaultInput" class="form-control" type="text" style="border-radius: 30px;" name="tname" required>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 30px;">Add Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="wrapper">
        <?php include('sidebar.php');?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('topbar.php');?>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary text-center">Booking Details</h4>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">Add Booking Details</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        
                                        <th>Datetime</th>
                                        <th>Company name</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Code</th>
                                        <th>Course</th>
                                        <th>Session</th>
                                        <th>Price</th>
                                        <th>Teacher's name</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `savedata`");
                                            $stmt->execute();
                                            $ints = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$ints) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                                foreach($ints as $int)  {  
                                        ?>
                                        <tr align="center">
                                            
                                            <td><?= $int['date']; ?></td>
                                            <td><?= $int['com_name']; ?></td>
                                            <td><?= $int['name']; ?></td>
                                            <td><?= $int['quantity']; ?></td>
                                            <td><?= $int['code']; ?></td>
                                            <td><?= $int['course']; ?></td>
                                            <td><?= $int['session']; ?></td>
                                            <td><?= $int['price']; ?></td>
                                            <td><?= $int['teacher_name']; ?></td>
                                            <td align="center">
                                                <!-- <button class="btn btn-warning" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#editGroupModal<?= $int['id']?>">แก้ไข</button> -->
                                                <!-- <a href="Edit_int.php?edit_id=<?= $int['id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.9rem;" name="edit"  data-toggle="modal" data-target="#editdataModal<?= $int['id']?>">แก้ไข</a> -->
                                                <a data-id="<?= $int['id']; ?>" href="?delete=<?= $int['id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.9rem;">ลบ</a>
                                            </td>
                                        </tr>
                                        <?php
                                                }      
                                            }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>

    $(".delete-btn").click(function(e) {
        var userId = $(this).data('id');
        e.preventDefault();
        deleteConfirm(userId);
    })

    function deleteConfirm(userId) {
        Swal.fire({
            title: 'ลบข้อมูล',
            text: "คุณแน่ใจใช่หรือไม่ที่จบลบข้อมูลนี้",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบข้อมูล',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                            url: 'booking.php',
                            type: 'GET',
                            data: 'delete=' + userId,
                        })
                        .done(function() {
                            Swal.fire({
                                title: 'สำเร็จ',
                                text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                icon: 'success',
                            }).then(() => {
                                document.location.href = 'booking.php';
                            })
                        })
                        .fail(function() {
                            Swal.fire({
                                title: 'ไม่สำเร็จ',
                                text: 'ลบข้อมูลไม่สำเร็จ',
                                icon: 'danger',
                            })
                            window.location.reload();
                        });
                });
            },
        });
    }

    // $.extend(true, $.fn.dataTable.defaults, {
    //     "language": {
    //             "sProcessing": "กำลังดำเนินการ...",
    //             "sLengthMenu": "แสดง _MENU_ รายการ",
    //             "sZeroRecords": "ไม่พบข้อมูล",
    //             "sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
    //             "sInfoEmpty": "แสดงรายการ 0 ถึง 0 จาก 0 รายการ",
    //             "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกรายการ)",
    //             "sInfoPostFix": "",
    //             "sSearch": "ค้นหา:",
    //             "sUrl": "",
    //             "oPaginate": {
    //                             "sFirst": "เริ่มต้น",
    //                             "sPrevious": "ก่อนหน้า",
    //                             "sNext": "ถัดไป",
    //                             "sLast": "สุดท้าย"
    //             }
    //     }
    // });
    // $('.table').DataTable();
    </script>

</body>

</html>