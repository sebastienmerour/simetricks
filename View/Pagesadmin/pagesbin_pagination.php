<!-- Pagination des pages  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
    if ($pages_deleted_current_page > $number_of_pages_deleted_pages) {
      require __DIR__ . '/../errors/pages_not_found.php';
    }
        else {
          if ($pages_deleted_current_page !=1  AND $pages_deleted_current_page <= $number_of_pages_deleted_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>pagesadmin/pagesbin/<?= $page_previous_pages_deleted ;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }

          for ($i = 1; $i <= $number_of_pages_deleted_pages; $i++)
          {
            echo '<li';
            if($pages_deleted_current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                echo '><a class="btn btn-outline-primary" href="'. BASE_ADMIN_URL .'pagesadmin/pagesbin/' . $i . '">' . $i . '</a>&nbsp;</li>';
              }
          }
          if ($pages_deleted_current_page < $number_of_pages_deleted_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>pagesadmin/pagesbin/<?= $page_next_pages_deleted; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        }
        ?>
      </ul>
    </nav>
