<ul class="nav nav-tabs pl-2" id="pills-first" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-items-tab" data-toggle="pill" href="#items" role="tab" aria-controls="pills-items" aria-selected="true">Mes dernières Extended Cards</a>
    </li>
</ul>
<div class="tab-content" id="pills-first">
  <div class="tab-pane fade show active p-2" id="pills-items-tab" role="tabpanel" aria-labelledby="pills-home-tab">
    <table class="table table-striped">
    <tbody>
      <?php foreach ($items_from_user as $item):?>
          <tr>
            <th scope="row"><a href="<?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($item['itemid'])  . "/1/". $this->clean($item['slug']) : "extendedcard/indexuser/" . $this->clean($item['itemid']). "/1/" .$this->clean($item['slug']);?>"><?= $this->clean($item['title']) ?></span></a></th>
            <td class="fs-6">publiée le <?= $this->clean($item['date_creation_fr']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
