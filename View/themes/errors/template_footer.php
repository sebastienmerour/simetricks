<footer class="mt-auto bg-primary-alt">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-auto">
        <a href="<?= BASE_URL; ?>">
          <img src="<?= BASE_URL; ?>public/images/logos/logo-xl.png" alt="<?= WEBSITE_NAME; ?>" title="<?= WEBSITE_NAME; ?>" class="icon icon-lg">
        </a>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col">
        <ul class="nav justify-content-center">
          <li class="nav-item"><a href="cards" class="nav-link">Cards</a>
          </li>
          <li class="nav-item"><a href="extendedcards" class="nav-link">Extended Cards</a>
          </li>
          <li class="nav-item"><a href="category/1/1/front-end" class="nav-link">Front-End</a>
          </li>
          <li class="nav-item"><a href="category/3/1/back-end" class="nav-link">Back-End</a>
          </li>
          <li class="nav-item"><a href="category/2/1/langages" class="nav-link">Langages</a>
          </li>
          <li class="nav-item"><a href="category/4/1/outils" class="nav-link">Outils</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="row justify-content-center text-center">
      <div class="col-xl-10">
        <small class="text-muted">&copy; <?= COPYRIGHT_YEAR. ' Tous droits réservés.' ;?></small>
      </div>
    </div>
  </div>
</footer>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="<?= BASE_URL; ?>public/js/scroll.js"></script>
<script src="<?= BASE_URL; ?>public/jquery/tab.js"></script>
<script src="<?= BASE_URL; ?>public/js/prism.js"></script>
<script src="<?= BASE_URL; ?>public/js/password_policy.js"></script>
<script src="<?= BASE_URL; ?>public/js/theme.js"></script>
<script>
    $('#uploadimage').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        fileName = fileName.substring(fileName.lastIndexOf("\\") + 1, fileName.length);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>
</body>
</html>
