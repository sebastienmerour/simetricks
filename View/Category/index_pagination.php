<!-- Pagination des items  -->
<div class="row justify-content-between align-items-center">
  <?php
  if ($items_current_page > $number_of_items_pages) {
    require __DIR__ . '/../errors/page_not_found.php';
  }
      else {;?>
        <div class="col-auto">
          <?php
        if ($items_current_page > 1  AND $items_current_page <= $number_of_items_pages)
        {
        ?>
    <a href="<?= BASE_URL. 'category/'.$id_category. '/'. $previous_page; ?>" class="btn btn-outline-white">Préc</a>
  <?php
  }; ?>

</div>
  <div class="col-auto">
    <nav>
      <ul class="pagination mb-0">
        <?php for ($i = 1; $i <= $number_of_items_pages; $i++)
        {
          echo '<li';
          if($items_current_page == $i)
            {
              echo ' class="page-item disabled"><a class="page-link" href="#">'.$i.' </a></li>';
            }
            else {
              echo ' class="page-item active"><a class="page-link" href="'. BASE_URL . 'category/'.$id_category. '/'.$i.'">' .$i. '</a></li>';
            }
        };?>
        </ul>
      </nav>
    </div>
    <div class="col-auto">
    <?php if ($items_current_page < $number_of_items_pages)
        {
        ?><a href="<?= BASE_URL. 'category/'.$id_category. '/'. $next_page; ?>" class="btn btn-outline-white">Suiv</a><?php };?>
      </div>
      <?php };?>
</div>
