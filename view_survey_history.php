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
					$question = $conn->query("SELECT *,cau_hoi.noi_dung as cauhoi,cau_tra_loi.noi_dung as cautraloi FROM cau_hoi INNER JOIN cau_tra_loi ON cau_hoi.id = cau_tra_loi.id_cauhoi 
                    where cau_hoi.id_khaosat = $id and cau_tra_loi.id_khaosat = $id order by abs(thu_tu) asc");

					while($row=$question->fetch_assoc()):
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['cauhoi'] ?></h5>
						<div class="col-md-12">
                            <input type="hidden" name="qid[]" value="<?php echo $row['id'] ?>">	
                            <?php
                                if($row['loai_cau_hoi'] == 'radio_opt'):
                                    foreach(json_decode($row['lua_chon']) as $k => $v):
                            ?>
                                <div class="icheck-primary">
                                    <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" <?php if ($k == $row['cautraloi']) {
                                        echo "checked";
                                    }?> disabled>
                                    <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                </div>
                                <?php endforeach; ?>
                            <?php elseif($row['loai_cau_hoi'] == 'check_opt'):
                                        foreach(json_decode($row['lua_chon']) as $k => $v):
                                ?>
                                <div class="icheck-primary">
                                    <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?> " <?php if (str_contains($row['cautraloi'],$k)) {
                                        echo 'checked';
                                    }?> disabled>
                                    <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
                                </div>
                                    <?php endforeach; ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="<?php echo $row['cautraloi'] ?>" disabled></textarea>
                                </div>
                            <?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
                <div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2" disabled>Lưu</button>
				</div>
				</form>
			</div>
		</div>


<script>
    
	
</script>



