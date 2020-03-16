<div id="repeater">
	<div class="row">
		<div class="col-6">
			<select class="form-control" data-name="link[]" data-skip-name="true" id="link">
				<option selected>
					Sélectionnez un lien
				</option>
				<?php
				foreach ($links as $link):?>
				<option value="<?= $this->clean($link['id']);?>"><?= $this->clean($link['name']); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-6">
			<div>
				<button class="btn btn-success repeater-add-btn" type="button">+</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<select class="form-control" data-name="link[]" data-skip-name="true" id="link">
				<option selected>Sélectionnez un lien</option>
					<?php	foreach ($links as $link):?>
						<option value="<?= $this->clean($link['id']);?>"><?= $this->clean($link['name']); ?></option>
					<?php endforeach; ?>
			</select>
		</div>
		<div class="col-6">
			<div>
				<button class="btn btn-danger" id="remove-btn" onclick="$(this).parents('.items').remove()">-</button>
			</div>
		</div>
	</div>
</div>
