<div class="row">
	<div class="col s10 push-s2">
		<div class="row titleRow">
			<h4 class="col s8">
				<?php echo $title; ?>
			</h4>
		</div>
		<div class="row">
			<hr />
		</div>

		<div class="row" style="position:relative;">
			<div class="col s7">
				<div class="row" style="padding:0px; margin-top:20px;">
					<div class="col s4 grey-text lighten-2" style="padding:0px;">
						<div class="card" style="padding:10px 20px;margin-bottom:10px;min-height:190px;">
							<p class="grey-text text-darken-1">Pada Bulan <?php echo date("m"); ?> Tahun <?php echo date("Y"); ?></p>
							<ul>
								<li class="row" style="margin-bottom:0px;"><span class="col s6 ">Penerimaan</span><span class="col s6 numeric" style="text-align:right;" id="penerimaan">0</span></li>
								<li class="row" style="margin-bottom:0px;"><span class="col s6">Pengeluaran</span><span class="col s6 numeric" style="text-align:right;" id="pengeluaran">0</span></li>
								<li class="row" style="height:3px;margin-bottom:0px;"><hr /> </li>
								<li class="row grey-text text-darken-2" style="margin-bottom:0px;"><span class="col s6">Total</span><span class="col s6 numeric" style="text-align:right;" id="total">0</span></li>
							</ul>
						</div>
					</div>
					<div class="col s6 grey-text lighten-2" style="padding:0px; margin-left:20px;">
						<div class="card" style="padding:10px 20px;margin-bottom:10px;">
							<div class="row">
								<div class="col s8">
									<p class="grey-text text-darken-1">Saldo Keseluruhan</p>
									<ul>
										<li class="row" style="margin-bottom:0px;"><span class="col s5 ">Kas</span><span class="col s7 numeric" style="text-align:right;" id="saldoKas">0</span></li>
										<li class="row" style="margin-bottom:0px;"><span class="col s5">Bank</span><span class="col s7 numeric" style="text-align:right;" id="saldoBank">0</span></li>
										<li class="row" style="height:3px;margin-bottom:0px;"><hr /> </li>
										<li class="row grey-text text-darken-2" style="margin-bottom:0px;"><span class="col s5">Total</span><span class="col s7 numeric" style="text-align:right;" id="totalSaldo">0</span></li>
									</ul>
								</div>
								<div class="col s4">
									<canvas id="chartSaldo" width="300" height="400"></canvas>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<table class="striped" id="kas-list">
					<thead>
						<tr>
							<th>No</th>
							<th></th>
							<th>Tanggal</th>
							<th>Kode</th>
							<th>Keterangan</th>
							<th>Penerimaan</th>
							<th>Pengeluaran</th>
							<th>&nbsp;&nbsp;&nbsp;&nbsp;</th>
						</tr>
					</thead>
					<tbody id="kas-list-items">
						<?php foreach ($kas as $kas_item): ?>
						<tr style="position:relative;" data-id="<?php echo $kas_item['id']; ?>">
							<td width="5%" class="row-no">
								<?php echo $kas_item['no']; ?>
							</td>
							<td width="4%">
								<?php if($kas_item["bank"] != 0) {?>
									<span class="pink lighten-1 row-type" style="width:12px;height:12px;display:block;border-radius:10px;"></span>
								<?php } else {?>
									<span class="blue lighten-1 row-type" style="width:12px;height:12px;display:block;border-radius:10px;"></span>
								<?php } ?>
								
							</td>
							<td width="12%" class="row-tanggal">
								<?php echo $kas_item['tanggal']; ?>
							</td>
							<td width="8%" class="row-kode tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $kas_item['nama'];?>">
								<?php echo $kas_item['kode']; ?>
							</td>
							<td class="row-ket">
								<?php echo $kas_item['ket']; ?>
							</td>
							<?php
                        $nilai = $kas_item["kas"];
                        if($kas_item["bank"] != 0) $nilai = $kas_item["bank"];
                        if($kas_item["status"] == "1"){ 
                            ?>
								<td width="15%" class="row-pemasukan">
									<span class="numeric"><?php echo $nilai; ?></span>
								</td>
								<td width="15%" class="row-pengeluaran">
									<span class="numeric">0</span>
								</td>
								<?php }else{?>
								<td width="15%" class="row-pemasukan">
									<span class="numeric">0</span>
								</td>
								<td width="15%" class="row-pengeluaran">
									<span class="numeric"><?php echo $nilai; ?></span>
								</td>
								<?php } ?>
								<td  width="9%">
									<span class="action-column">
										<a class="action-edit">
											<i class="material-icons">create</i>
										</a>
										<a class="action-delete">
											<i class="material-icons">delete</i>
										</a>
									</span>
								</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="col-md-12 center text-center">
					<span class="left" id="total_reg"></span>
					<ul class="pagination pager" id="myPager"></ul>
				</div>
			</div>
			<div class="col s4" style="position:fixed;right:0;top:100px;transition:all 0.5s;" id="form-card">
				<div class="card">
					<form id="kas-form">
						<div class="card-content">
							<span class="card-title">Tambah Kas</span>

							<div class="row">
								<div class="input-field col s4">
									<input id="kas-no" name="kas-no" type="text" class="validate">
									<label for="kas-no">No</label>
								</div>
								<div class="input-field col s8" style="position:relative;">
									<input id="kas-kode" name="kas-kode" type="text" class="validate autocomplete">
									<label for="kas-kode">Kode</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="kas-tanggal" name="kas-tanggal" type="text">
									<label for="kas-tanggal">Tanggal</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<textarea id="kas-ket" name="kas-ket" class="materialize-textarea"></textarea>
									<label for="kas-ket">Keterangan</label>
								</div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <p>Status</p>
                                    <p>
                                        <input class="with-gap" name="status" type="radio" id="kas-status-1" value="1" />
                                        <label for="kas-status-1">Penerimaan</label>
                                    </p>
                                    <p>
                                        <input class="with-gap" name="status" type="radio" id="kas-status-2" value="2"/>
                                        <label for="kas-status-2">Pengeluaran</label>
                                    </p>
                                </div>
                                <div class="col s6">
                                    <p>Tipe</p>
                                    <p>
                                        <input class="with-gap" name="type" type="radio" id="kas-type-1" value="1"  />
                                        <label for="kas-type-1">Kas</label>
                                    </p>
                                    <p>
                                        <input class="with-gap" name="type" type="radio" id="kas-type-2" value="2" />
                                        <label for="kas-type-2">Bank</label>
                                    </p>
                                </div>
                            </div>
							<div class="row">
								<div class="input-field col s12">
									<input id="kas-nilai" name="kas-nilai" type="text" class="numeric">
									<label for="kas-nilai">Nilai</label>
								</div>
							</div>
						</div>
						<div class="card-action">
							<input id="kas-submit" class="waves-effect waves-light btn blue" type="submit" value="Tambah">
							<a id="kas-batal" class="waves-effect waves-light btn blue" style="display:none;">Batal</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Structure -->
<div id="modal-delete" class="modal modal-fixed-footer"  style="max-height:30%;top:30% !important;">
    <div class="modal-content" style="max-height:200px;">
      <h4>Menghapus Kas</h4>
      <p>Apakah kamu ingin menghapus kas ini?</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat btn-delete-yes">Iya</a>
	  <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat btn-delete-cancel">Batal</a>
    </div>
  </div>

<script src="<?php echo base_url("assets/js/app-kas.js");?>"></script>
