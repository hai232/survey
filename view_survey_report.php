<?php include 'db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM khao_sat where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
$taken = $conn->query("SELECT distinct(id_nguoidung) from cau_tra_loi where id_khaosat ={$id}")->num_rows;
$answers = $conn->query("SELECT a.*,q.loai_cau_hoi from cau_tra_loi a inner join cau_hoi q on q.id = a.id_cauhoi where a.id_khaosat ={$id}");
$ans = array();

while($row=$answers->fetch_assoc()){
	if($row['loai_cau_hoi'] == 'radio_opt'){
		$ans[$row['id_cauhoi']][$row['noi_dung']][] = 1;
	}
	if($row['loai_cau_hoi'] == 'check_opt'){
		foreach(explode(",", str_replace(array("[","]"), '', $row['noi_dung'])) as $v){
		$ans[$row['id_cauhoi']][$v][] = 1;
		}
	}
	if($row['loai_cau_hoi'] == 'textfield_s'){
		$ans[$row['id_cauhoi']][] = $row['noi_dung'];
	}
}
?>
<style>
	.tfield-area{
		max-height: 30vh;
		overflow: auto;
	}
</style>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title"><b>Chi tiết khảo sát</b></h3>
					
				</div>
				<div class="card-body p-0 py-2">
					<div class="container-fluid">
						<p>Tiêu đề: <b><?php echo $ten_khao_sat ?></b></p>
						<p class="mb-0">Miêu tả:</p>
						<small><?php if ($loai_khao_sat == 1) echo 'Mục tiêu chương trình đào tạo';
                            elseif ($loai_khao_sat == 2) echo 'Đội ngũ giảng viên';
                            elseif ($loai_khao_sat == 3) echo 'Công tác tổ chức đào tạo';
                            elseif ($loai_khao_sat == 4) echo 'Phòng đào tạo';
                            elseif ($loai_khao_sat == 5) echo 'Thư viện';
                            elseif ($loai_khao_sat == 6) echo 'Căng tin';
                            elseif ($loai_khao_sat == 7) echo 'Một số hoạt động khác của trường';?></small>
						<p>Bắt đầu: <b><?php echo date("M d, Y",strtotime($ngay_bat_dau)) ?></b></p>
						<p>Kết thúc: <b><?php echo date("M d, Y",strtotime($ngay_ket_thuc)) ?></b></p>
						<p>Số lượng người tham gia: <b><?php echo number_format($taken) ?></b></p>


					</div>
					<hr class="border-primary">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-success">
				<div class="card-header">
					<h3 class="card-title"><b>Báo cáo khảo sát</b></h3>
					<div class="card-tools">
						<button class="btn btn-flat btn-sm bg-gradient-success" type="button" id="print"><i class="fa fa-print"></i> In</button>
					</div>
				</div>
				<div class="card-body ui-sortable">
					<?php 
					$question = $conn->query("SELECT * FROM cau_hoi where id_khaosat = $id order by abs(thu_tu) asc,abs(id) asc");
					while($row=$question->fetch_assoc()):	
					?>
					<div class="callout callout-info">
						<h5><?php echo $row['noi_dung'] ?></h5>
						<div class="col-md-12">
						<input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['loai_cau_hoi'] ?>">
							
							<?php if($row['loai_cau_hoi'] != 'textfield_s'):?>
								<ul>
							<?php foreach(json_decode($row['lua_chon']) as $k => $v):
								$prog = ((isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0) / ($taken == 0 ? 1 : $taken)) * 100;
								$prog = round($prog,2);
								?>
								<li>
									<div class="d-block w-100">
										<b><?php echo $v ?></b>
									</div>
									<div class="d-flex w-100">
									<span class=""><?php echo isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0 ?>/<?php echo $taken ?></span>
									<div class="mx-1 col-sm-8"">
									<div class="progress w-100" >
					                  <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
					                    <span class="sr-only"><?php echo $prog ?>%</span>
					                  </div>
					                </div>
					                </div>
					                <span class="badge badge-info"><?php echo $prog ?>%</span>
									</div>
								</li>
								<?php endforeach; ?>
								</ul>
						<?php else: ?>
							<div class="d-block tfield-area w-100 bg-dark">
								<?php if(isset($ans[$row['id']])): ?>
								<?php foreach($ans[$row['id']] as $val): ?>
								<blockquote class="text-dark"><?php echo $val ?></blockquote>
								<?php endforeach; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#manage-survey').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_answer',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Cảm ơn.",'success')
					setTimeout(function(){
						location.href = 'index.php?page=survey_widget'
					},2000)
				}
			}
		})
	})
	$('#print').click(function(){
		start_load()
		var nw = window.open("print_report.php?id=<?php echo $id ?>","_blank","width=800,height=600")
			nw.print()
			setTimeout(function(){
				nw.close()
				end_load()
			},2500)
	})
</script>