<?php 
session_start();

require_once '../../config/utils.php';
checkAdminLoggedIn();

$getRolesQuery = "select * from roles where status = 1";
$roles = queryExecute($getRolesQuery, true);


$getUsersQuery = "select 
                                u.*, 
                                r.name as role_name
                    from users u
                    join roles r
                    on u.role_id = r.id";

// $getUsersQuery = "select * from users";


//dd($getUsersQuery);
$users = queryExecute($getUsersQuery, true);
 ?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Sparta</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include_once '../_share/css.php'; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include_once '../_share/header.php'; ?>
  <!-- Navbar -->
  <?php include_once '../_share/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <table class="table table-bordered">
    	<thead>
    		<tr>
    			<th scope="col">ID</th>
    			<th scope="col">Ten</th>
    			<th scope="col">Email</th>
    			<th scope="col">Anh</th>
          <th>Loại tài khoản</th>
    			<th>
    				<a href="<?php echo ADMIN_URL . 'users/add.php'?>" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm</a>
    			</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php foreach ($users as $us): ?>
    		<tr>
    			<td><?php echo $us['id']?></td>
    			<td><?php echo $us['fullname']?></td>
    			<td><?php echo $us['email']?></td>
    			<td>
    				<img class="img-fluid" src="<?= BASE_URL . $us['avatar']?>" alt="" width="100">
    			</td>
          <td>
            <?php echo $us['role_name']?>
          </td>
    			<td>
    				<?php if($us['role_id'] < $_SESSION[AUTH]['role_id'] || $us['id'] === $_SESSION[AUTH]['id']): ?>
    					<a href="<?php echo ADMIN_URL . 'users/edit.php?id=' . $us['id'] ?>" class="btn btn-sm btn-info">
    						<i class="fas fa-pencil-alt"></i>
    					</a>
    				<?php endif; ?>
    				<?php if($us['role_id'] < $_SESSION[AUTH]['role_id']): ?>
    					<a href="<?php echo ADMIN_URL . 'users/remove.php?id=' . $us['id'] ?>" class="btn-remove btn btn-sm btn-danger">
    						<i class="fa fa-trash"></i>
    					</a>
    				<?php endif; ?>
    			</td>
    		</tr>
    		<?php endforeach;?>
    	</tbody>
    </table>




  </div>
  <!-- /.content-wrapper -->

  <?php include_once '../_share/footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
  <?php include_once '../_share/js.php'; ?>
  <script>
    $(document).ready(function(){
        $('.btn-remove').on('click', function () {
            var redirectUrl = $(this).attr('href');
            Swal.fire({
                title: 'Thông báo!',
                text: "Bạn có chắc chắn muốn xóa tài khoản này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý'
            }).then((result) => { // arrow function es6 (es2015)
                if (result.value) {
                    window.location.href = redirectUrl;
                }
            });
            return false;
        });
        <?php if(isset($_GET['msg'])):?>
        Swal.fire({
            position: 'bottom-end',
            icon: 'warning',
            title: "<?= $_GET['msg'];?>",
            showConfirmButton: false,
            timer: 1500
        });
        <?php endif;?>
    });
</script>
</body>
</html>