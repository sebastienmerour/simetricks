<div class="page-header">
<h3>
<select id="category" name="category">
<option selected="selected">Filtrer par Catégorie</option>
<?php
foreach ($categories as $category):?>
<option value="<?= $this->clean($category['id']);?>" id="<?= $this->clean($category['id']);?>"><?= $this->clean($category['name']); ?></option>
<?php endforeach; ?>
</select>
</h3>
</div>

JANVIER 2021 :
<div class="page-header">
<h3>
<select name="category" id="category" multiple class="form-control selectpicker" title="Live data search par catégorie...">
  <option selected="selected">Filtrer par Catégorie</option>
  <?php
  foreach ($categories as $category):?>
  <option value="<?= $this->clean($category['id']);?>" id="<?= $this->clean($category['id']);?>"><?= $this->clean($category['name']); ?></option>
<?php endforeach; ?>
</select>
</h3>
</div>
