<?php
	$tahun = date('Y');
	$bulan = date('m');
?>

<div class="row">
	<div class="col s10 push-s2" id="totalKas">
		<div class="row titleRow">
			<h4 class="col s8">
				<?php echo $title; ?>
			</h4>
			<div class="col s4 pageAcion">
				<a href="#" id="actionPrintPage"><i class="material-icons">print</i></a>
			</div>
		</div>
		<div class="row">
			<hr />
		</div>
		

		<form class="row" id="kasFilter" style="position:relative;">
			<div class="input-field col s3">
				<select id="filterTahun">
				<option value="" disabled>Pilih Tahun Kas</option>
				<option value="<?php echo $tahun;?>" selected><?php echo $tahun;?></option>
				<?php
					for($i = 1; $i <= 10; $i++){
						$tahun -= 1;
				?>
				<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
				<?php } ?>
				</select>
				<label>Tahun</label>
			</div>
			<div class="input-field col s3">
				<select id="filterBulan">
				<option value="" disabled>Pilih Bulan Kas</option>
				<?php
					for($i = 1; $i <= 12; $i++){
						if($i == $bulan){
				?>
					<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
				<?php
					}else{ ?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
					}
				}?>
				</select>
				<label>Bulan</label>
			</div>
			<input id="kode-submit" class="waves-effect waves-light btn blue" type="submit" value="Filter" style="position:absolute;bottom:20px;">
		</form>

		<div class="row" id="printArea">
			<div class="col s6" >
				<div class="card cardResult penerimaan">
					<h5>Penerimaan</h5>
					<table>
						<thead>
							<tr>
								<td width="8%">No</td>
								<td width="14%">Kode</td>
								<td>Nama</td>
								<td width="30%">Nilai</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$index = 0;
								foreach($kas as $kas_item) : 
								if($kas_item["status"] == "1"){
									$index += 1;
								?>
								<tr>
									<td><?php echo $index;?></td>
									<td><?php echo $kas_item["kode"];?></td>
									<td><?php echo $kas_item["nama"];?></td>
									<td><span class="numeric"><?php echo $kas_item["nilai"];?></span></td>
								</tr>
							<?php
								}
								 endforeach;?>
						</tbody>
					</table>
					<div class="row cardFooter">
						<div class="col s7">
							Total
						</div>
						<div class="col s5 cardTotal">
						<p class="numeric"><?php echo $penerimaan ?></p>
						</div>
					</div>
				</div>
			</div>

			<div class="col s6">
				<div class="card cardResult pengeluaran">
					<h5>Pengeluaran</h5>
					<table>
						<thead>
							<tr>
								<td width="8%">No</td>
								<td width="14%">Kode</td>
								<td>Nama</td>
								<td width="30%">Nilai</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$index = 0;
								foreach($kas as $kas_item) : 
								if($kas_item["status"] == "2"){
									$index += 1;
								?>
								<tr>
									<td><?php echo $index;?></td>
									<td><?php echo $kas_item["kode"];?></td>
									<td><?php echo $kas_item["nama"];?></td>
									<td><span class="numeric"><?php echo $kas_item["nilai"];?></span></td>
								</tr>
							<?php
								}
								 endforeach;?>
						</tbody>
					</table>
					<div class="row cardFooter">
						<div class="col s7">
							Total
						</div>
						<div class="col s5 cardTotal">
							<p class="numeric"><?php echo $pengeluaran ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col s6 cardStatus" >
				<?php if($selisih < 0){ ?>
					<span class="red"></span>
				<?php } else if($selisih > 0) { ?>
					<span class="green"></span>
				<?php } else { ?>
					<span class="grey"></span>
				<?php } ?>

				<p class="grey-text numeric nilaiSelisih"><?php echo $selisih ?></p>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url("assets/js/app-kastotal.js");?>"></script>