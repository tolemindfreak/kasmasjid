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
                    <div class="col s3 grey-text lighten-2" style="padding:0px;">
                        <h6>Jumlah Kode : <?php echo count($kas);?></h6>
                    </div>
                </div>
                <table class="striped" id="kode-list">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kode</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="kode-list-items">
                    <?php foreach ($kas as $kas_item): ?>
                    <tr style="position:relative;">
                        <td width="10%" class="row-id"><?php echo $kas_item['id']; ?></td>
                        <td width="80%"  class="row-nama"><?php echo $kas_item['nama']; ?></td>
                        <td ><span class="action-column" data-id="<?php echo $kas_item['id']; ?>" data-nama="<?php echo $kas_item['nama']; ?>"><a class="action-edit"><i class="material-icons">create</i></a><a class="action-delete"><i class="material-icons">delete</i></a></span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="col-md-12 center text-center">
                <span class="left" id="total_reg"></span>
                    <ul class="pagination pager" id="myPager"></ul>
                </div>
            </div>
            <div class="col s4" style="position:fixed;right:0;top:190px;transition:all 0.5s;" id="form-card">
                <div class="card" >
                    <form id="kode-form">
                    <div class="card-content">
                        <span class="card-title">Tambah Kode</span>
                        
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="kode-id" name="kode-id" type="text" class="validate">
                                    <label for="kode-id">Kode</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="kode-nama" name="kode-nama" type="text" class="validate">
                                    <label for="kode-nama">Nama</label>
                                </div>
                            </div>
                        
                    </div>
                    <div class="card-action">
                        <input id="kode-submit" class="waves-effect waves-light btn blue" type="submit" value="Tambah">
                        <a id="kode-batal" class="waves-effect waves-light btn blue" style="display:none;">Batal</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/js/app-kode.js");?>"></script>




