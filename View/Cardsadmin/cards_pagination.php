<!-- Pagination des cards  -->
  <nav class="blog-pagination">
    &nbsp; <ul class="pagination">
    <?php
    if ($cards_current_page > $number_of_cards_pages) {
      require __DIR__ . '/../errors/page_not_found.php';
    }
        else {
          if ($cards_current_page !=1  AND $cards_current_page <= $number_of_cards_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>cardsadmin/<?= $page_previous_cards ;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>&nbsp;
          </li>
          <?php
          }

          for ($i = 1; $i <= $number_of_cards_pages; $i++)
          {
            echo '<li';
            if($cards_current_page == $i)
              {
                echo ' class="btn btn-outline-secondary disabled">'.$i.' </li>&nbsp;';
              }
              else {
                echo '><a class="btn btn-outline-primary" href="'. BASE_ADMIN_URL .'cardsadmin/' . $i . '">' . $i . '</a>&nbsp;</li>';
              }
          }
          if ($cards_current_page < $number_of_cards_pages)
          {
          ?>
          <li>
              <a class="btn btn-outline-secondary" href="<?= BASE_ADMIN_URL; ?>cardsadmin/<?= $page_next_cards; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
          <?php
          }
        }
        ?>
      </ul>
    </nav>
