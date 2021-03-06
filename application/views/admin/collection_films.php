<?php
$active = isset($_GET['active']) ? $_GET['active'] : 'list';

?>
<div class="row">
	<div class="col-xs-12">
		<h3 class="m-t-0 m-b-20 header-title"><?php echo $name ?></h3>
	</div>
</div>
<ul class="nav nav-tabs">
	<li <?= $active == 'list' ? 'class="active"' : '' ?>>
		<a data-toggle="tab" href="#list">List Films in <?php echo $name ?></a>
	</li>
	<li <?= $active == 'add' ? 'class="active"' : '' ?>>
		<a data-toggle="tab" href="#add">Add film to <?php echo $name ?></a>
	</li>
</ul>

<div class="row card-box">
	<div class="tab-content" style="box-shadow: none!important;">
		<div id="list" class="tab-pane fade in<?= $active == 'list' ? ' active' : '' ?>">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
						<table id="example3" class="table table-striped table-bordered" data-alert="Are you want to delete this product?">
							<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Name</th>
								<th>Year</th>
								<th>Position</th>
								<th>Actions</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($products != null && count($products) > 0) {
								foreach ($products as $row): ?>
									<tr>
										<td align="center"><?php echo $row['product_id']; ?></td>
										<td><img style="max-width: 70px; max-height: 70px" src="<?= media_thumbnail($row['promo_image']) ?>"/></td>
										<td><?php echo $row['name'] ?></td>
										<td><?php echo $row['publish_year']; ?></td>
										<?php echo '<td><div class="button-list">';
										if ($row['priority_collection'] > 1) {
											echo "<a href='" . base_url('collection/upFilm/' . $collection_id . '/' . $row['priority_collection']) . '/' . $row['id'] . "'>
				                                    <button class='btn btn-sm btn-purple'><i class='fa fa-long-arrow-alt-up'></i> Up</button>
				                                </a>";
										}
										if ($row['priority_collection'] < $max) {
											echo "<a href='" . base_url('collection/downFilm/' . $collection_id . '/' . $row['priority_collection']) . '/' . $row['id'] . "'>
				                                    <button class='btn btn-sm btn-inverse'><i class='fa fa-long-arrow-alt-down'></i> Down</button>
				                                </a>";
										}
										echo '</div></td>'; ?>
										<td>
											<div class='button-list'>
												<a href='<?php echo base_url('collection/editPromo/' . $row['id']) ?>'>
													<button class='btn btn-inverse btn-custom btn-xs'>Edit</button>
												</a>
												<a href='<?php echo base_url('collection/removeFilm/' . $collection_id . '/' . $row['product_id'] . '/' . $row['priority_collection']) ?>'>
													<button class='btn btn-danger btn-custom btn-xs'>Remove</button>
												</a>
											</div>
										</td>
									</tr>
								<?php endforeach;
							} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="add" class="tab-pane fade in<?= $active == 'add' ? ' active' : '' ?>">
			<div class="row">
				<div class="col-md-6">
					<?php
					if ($this->session->flashdata('alert')) {
						echo '<div class="row"><div class="col-xs-12 alert alert-success">';
						echo $this->session->flashdata('alert');
						echo '</div></div>';
					}
					if ($this->session->flashdata('error')) {
						echo '<div class="col-xs-12"><div class="alert alert-danger">';
						echo $this->session->flashdata('error');
						echo '</div></div>';
					}
					?>
					<form method='POST' enctype="multipart/form-data" action="<?= base_url('collection/addToCollection') ?>">
						<div class="form-group" id='block_product'>
							<label>Film</label>
							<input id='select_product' class='form-control' type="text" placeholder='Film Name' required
							       data-href='<?php echo base_url("collection/ajaxProduct/{$collection_id}?q=") ?>'
							       data-linked-id='product_id'/>
							<input type="hidden" id='product_id' name='product_id' class='form-control'/>
							<input type="hidden" name='collection_id' class='form-control' value="<?= $collection_id ?>"/>
						</div>
						<!-- <div class="form-group m-b-30">
							<label>Promo Image</label>
							<div class="row">
								<div class="col-md-4">
									<img id='image' width='120' height='120' style='border: 4px solid #c6c6c6; border-radius: 4px'/>
								</div>
								<div class="col-md-8">
									<img style="padding-left: 45%;position: absolute;top: 40%;" src="<?php echo base_url('assets/images/plus.png') ?>">
									<div class="uploader" onclick="$('#imagePhoto').click()">
										<input type="file" accept="image/*" name="promo_image" id="imagePhoto" required/>
									</div>
								</div>
							</div>
						</div> -->
						<div class="form-group">
							<button type="submit" class="btn btn-primary" name='cmd' value='Add'>Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>