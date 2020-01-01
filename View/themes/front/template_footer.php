<a href="#" class="btn back-to-top btn-primary btn-round" data-smooth-scroll data-aos="fade-up" data-aos-offset="2000" data-aos-mirror="true" data-aos-once="false">
  <img class="icon" src="<?= BASE_URL; ?>public/images/icons/theme/navigation/arrow-up.svg" alt="arrow-up icon" data-inject-svg />
</a>
<footer class="pb-5 mt-5 bg-primary-alt">
  <div class="container">
    <div class="row mb-4 justify-content-center">
      <div class="col-auto">
        <a href="index.html">
          <img src="<?= BASE_URL; ?>public/images/logo.svg" alt="Simetricks" class="icon icon-lg">
        </a>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col">
        <ul class="nav justify-content-center">
          <li class="nav-item"><a href="#" class="nav-link">Cards</a>
          </li>
          <li class="nav-item"><a href="#" class="nav-link">Extended Cards</a>
          </li>
          <li class="nav-item"><a href="#" class="nav-link">2.0</a>
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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="<?= BASE_URL; ?>public/js/scroll.js"></script>
<script src="<?= BASE_URL; ?>public/js/tab.js"></script>

<script type="text/javascript" src="<?= BASE_URL; ?>public/js/password_policy.js"></script>
<script type="text/javascript">
  window.addEventListener("load", function () {    document.querySelector('body').classList.add('loaded');  });
</script>
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
