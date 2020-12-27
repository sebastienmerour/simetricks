<!-- Pagination des pages  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
    if ($pages_current_page > $number_of_pages_pages) {
      require __DIR__ . '/../errors/page_not_found.php';
    }
        else {
          if ($pages_current_page !=1  AND $pages_current_page <= $number_of_pages_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>pagesadmin/<?= $page_previous_pages ;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }

          for ($i = 1; $i <= $number_of_pages_pages; $i++)
          {
            echo '<li';
            if($pages_current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                echo '><a class="btn btn-outline-primary" href="'. BASE_ADMIN_URL .'pagesadmin/' . $i . '">' . $i . '</a>&nbsp;</li>';
              }
          }
          if ($pages_current_page < $number_of_pages_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>pagesadmin/<?= $page_next_pages; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        }
        ?>
      </ul>
    </nav>
