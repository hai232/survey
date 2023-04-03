<?php 
include('db_connect.php');
session_start();
$utype = array('','admin','Sinh Viên','Giảng Viên', 'Doanh Nghiệp');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM nguoi_dung where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Tên</label>
			<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $meta['ten'] ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Email</label>
			<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Mật khẩu</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			
		</div>
		
		

	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Đã lưu dữ liệu thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Tên người dùng đã tồn tại</div>')
					end_load()
				}
			}
		})
	})

</script>