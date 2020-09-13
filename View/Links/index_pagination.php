<!-- Pagination des liens  -->
<div class="row justify-content-between align-cards-center">
  <?php
  if ($links_current_page > $number_of_links_pages) {
    require __DIR__ . '/../errors/page_not_found.php';
  }
      else {;?>
        <div class="col-auto">
          <?php
        if ($links_current_page > 1  AND $links_current_page <= $number_of_links_pages)
        {
        ?>
    <a href="<?= BASE_URL; ?>links/<?= $previous_page; ?>" class="btn btn-outline-white">Préc</a>
  <?php
  }; ?>


</div>
  <div class="col-auto">
    <nav>
      <ul class="pagination mb-0">
        <?php for ($i = 1; $i <= $number_of_links_pages; $i++)
        {
          echo '<li';
          if($links_current_page == $i)
            {
              echo ' class="page-item disabled"><a class="page-link" href="#">'.$i.' </a></li>';
            }
            else {
              echo ' class="page-item active"><a class="page-link" href="'. BASE_URL. 'links/'  . $i . '">' . $i . '</a></li>';
            }
        };?>
        </ul>
      </nav>
    </div>
    <div class="col-auto">
    <?php if ($links_current_page < $number_of_links_pages)
        {
        ?><a href="<?= BASE_URL; ?>links/<?= $next_page; ?>" class="btn btn-outline-white">Suiv</a><?php };?>
      </div>
      <?php };?>
</div>
