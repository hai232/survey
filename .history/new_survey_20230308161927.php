<?php
if(!isset($conn)){
	include 'db_connect.php' ;
}
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_survey">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">Tên khảo sát</label>
							<input type="text" name="title" class="form-control form-control-sm" required value="<?php echo isset($stitle) ? $stitle : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Ngày bắt đầu</label>
							<input type="date" name="start_date" class="form-control form-control-sm" required value="<?php echo isset($start_date) ? $start_date : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Ngày kết thúc</label>
							<input type="date" name="end_date" class="form-control form-control-sm" required value="<?php echo isset($end_date) ? $end_date : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Loại Khảo Sát</label>
							<select type="type" name="type" class="custom-select custom-select-sm">
								<option value="3" <?php echo isset($type) && $type == 4 ? 'selected' : '' ?>>Admin</option>
								<option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Giảng viên</option>
								<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Sinh viên</option>
								<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Doanh nghiệp</option>
							</select>
					</div>
					
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Lưu</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=survey_list'">Thoát</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('#manage_survey').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_survey',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=survey_list')
					},1500)
				}
			}
		})
	})
</script>