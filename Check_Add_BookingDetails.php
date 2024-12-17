<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";
    try {
       
        if (isset($_POST['submit'])) {
            $company = $_POST['company'];
            // echo "company = ".$company;

            $date = $_POST['date']; 
            // echo "date = ".$date;

            $name = $_POST['name']; 
            // echo "name = ".$name;

            $quan = $_POST['quan']; 
            // echo "quan = ".$quan;

            $code = $_POST['code']; 
            // echo "code = ".$code;

            // $course = $_POST['course']; 
            // echo "course = ".$course;

            $session = $_POST['session'];
            // echo "session = ".$session;

            $price = $_POST['price'];
            // echo "price = ".$price;

            $tname = $_POST['tname']; 
            // echo "tname = ".$tname;

            $status = '1' ;
            
            $pb = $db->prepare("INSERT INTO `savedata`(`com_name`, `date`, `name`, `quantity`, `code`, `session`, `price`, `teacher_name`, `status`) VALUES 
                                                    ('$company','$date','$name',$quan,'$code','$session',$price,'$tname','$status')");
            $pb->execute();

            if ($pb) {
                $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อย";
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'เพิ่มข้อมูลเรียบร้อย',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    })
                </script>";
                header("refresh:1; url=booking.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: booking.php");
            }      
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
   }
?>