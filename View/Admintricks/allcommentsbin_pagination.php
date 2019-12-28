<!-- Pagination des commentaires  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
<?php
  if ($comments_deleted_current_page !=1  AND $comments_deleted_current_page <= $number_of_comments_deleted_pages)// Si la page active n'est pas la première page
  {
  ?>
  <li>
      <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>allcommentsbin/<?= $comments_deleted_previous_page; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>&nbsp;
  </li>
  <?php


  }
  for ($i = 1; $i <= $number_of_comments_deleted_pages; $i++)
  {
    echo '<li';
    if($comments_deleted_current_page == $i)
      {
        echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
      }
      else {

        echo '><a class="btn btn-outline-primary" href="'. BASE_ADMIN_URL .'allcommentsbin/' . $i . '">' . $i . '</a>&nbsp;</li>';
      }
  }

  if ($comments_deleted_current_page < $number_of_comments_deleted_pages)
  {
  ?>
  <li>
      <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>allcommentsbin/<?= $comments_deleted_next_page; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
  </li>
<?php
  }
?>
</ul>
</nav>
