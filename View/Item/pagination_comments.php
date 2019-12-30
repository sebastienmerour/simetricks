<!-- Pagination des commentaires  -->
<div class="row justify-content-between align-items-center">
        <div class="col-auto">
          <?php
          if ($comments_current_page !=1  AND $comments_current_page <= $number_of_comments_pages)
        {
        ?>
    <a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/" . $page_previous_comments : "item/indexuser/" . $this->clean($item['id']).
    "/" . $page_previous_comments ?>/#comments" class="btn btn-outline-white">Préc</a>
  <?php
  }; ?>

</div>
  <div class="col-auto">
    <nav>
      <ul class="pagination mb-0">
        <?php for ($i = 1; $i <= $number_of_comments_pages; $i++)
        {
          echo '<li';
          if($comments_current_page == $i)
            {
              echo ' class="page-item disabled"><a class="page-link" href="#">'.$i.' </a></li>';
            }
            else {
              if (!ISSET($_SESSION['id_user'])) {
                echo ' class="page-item active"><a class="page-link" href="item/' .$this->clean($item['id']). '/'. $i . '/#comments">' . $i . '</a></li>';
              }
              else {
                echo ' class="page-item active"><a class="page-link" href="item/indexuser/' .$this->clean($item['id']). '/'. $i . '/#comments">' . $i . '</a></li>';
            }
        }
      };?>
        </ul>
      </nav>
    </div>
    <div class="col-auto">
    <?php if ($comments_current_page < $number_of_comments_pages)
        {
        ?><a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/" . $page_next_comments  : "item/indexuser/" . $this->clean($item['id']).
        "/" . $page_next_comments ?>/#comments" class="btn btn-outline-white">Suiv</a><?php };?>
      </div>

</div>
