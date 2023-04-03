<?php include 'db_connect.php' ?>
    <?php 
    $id = $_GET['id'];
    $survey = $conn->query("SELECT * FROM khao_sat where id = $id ");
    $row=$survey->fetch_assoc();
    
?>
        <div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b><?php echo ucwords($row['ten_khao_sat']).'</br>'; ?></b></h3>
				</div>
				<form action="" id="question">
				<div class="card-body ui-sortable">
					<?php 
					$question = $conn->query("SELECT * FROM cau_hoi where id_khaosat = $id order by abs(thu_tu) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['noi_dung'] ?></h5>
						<div class="col-md-12">
                            <input type="hidden" name="qid[]" value="<?php echo $row['id'] ?>">	
                            <?php
                                if($row['loai_cau_hoi'] == 'radio_opt'):
                                    foreach(json_decode($row['lua_chon']) as $k => $v):
                            ?>
                                <div class="icheck-primary">
                                    <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
                                    <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                </div>
                                <?php endforeach; ?>
                            <?php elseif($row['loai_cau_hoi'] == 'check_opt'):
                                        foreach(json_decode($row['lua_chon']) as $k => $v):
                                ?>
                                <div class="icheck-primary">
                                    <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?>" >
                                    <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                </div>
                                    <?php endforeach; ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="Viết gì đó ở đây..."></textarea>
                                </div>
                            <?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
                <div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Lưu</button>
				</div>
				</form>
			</div>
		</div>


<script>
    
	$('#question').submit(function(e){
        formData = new FormData($('#question')[0]);
        formData.append('id', <?php echo $id?>);
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_answer',
			data: formData,
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Đã lưu dữ liệu thành công.',"success");
					setTimeout(function(){
						location.replace('index.php?page=survey_list')
					},1500)
				}
			}
		})
	})
</script>



