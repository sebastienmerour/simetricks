<!-- Pagination des items  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
    if ($items_deleted_current_page > $number_of_items_deleted_pages) {
      require __DIR__ . '/../errors/page_not_found.php';
    }
        else {
          if ($items_deleted_current_page !=1  AND $items_deleted_current_page <= $number_of_items_deleted_pages)// Si la page active n'est pas la première page
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>extendedcardsbin/<?= $page_previous_items_deleted ;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }

          for ($i = 1; $i <= $number_of_items_deleted_pages; $i++)
          {
            echo '<li';
            if($items_deleted_current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                echo '><a class="btn btn-outline-primary" href="'. BASE_ADMIN_URL .'extendedcardsbin/' . $i . '">' . $i . '</a>&nbsp;</li>';
              }
          }
          if ($items_deleted_current_page < $number_of_items_deleted_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>extendedcardsbin/<?= $page_next_items_deleted; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        }
        ?>
      </ul>
    </nav>
