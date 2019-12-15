<div class="navbar-container ">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="<?= BASE_URL; ?>">
        <img src="<?= BASE_URL; ?>public/images/logo.svg" alt="Simetricks">
      </a>
      <div class="d-flex align-items-center order-lg-3">
        <form>
          <div class="input-group">
            <div class="input-group-prepend">
            </div>
          </div>
        </form>
          <div class="dropdown ml-2">
            <img src="<?= BASE_URL; ?>public/images/avatars/default.png" alt="User" class="avatar avatar-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="dropdown-menu dropdown-menu-right dropdown-content pl-2">
              <h6>Mon compte</h6>
              <a class="dropdown-item" href="<?= BASE_URL; ?>login">Se connecter</a>
              <a class="dropdown-item" href="<?= BASE_URL; ?>user/adduser">Inscription</a>
            </div>
          </div>
        <div class="ml-2">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <img class="icon navbar-toggler-open" src="assets/img/icons/interface/menu.svg" alt="menu interface icon" data-inject-svg />
            <img class="icon navbar-toggler-close" src="assets/img/icons/interface/cross.svg" alt="cross interface icon" data-inject-svg />
          </button>
        </div>
      </div>
      <div class="collapse navbar-collapse justify-content-between order-lg-2">
        <div class="py-2 py-lg-0">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="#" class="nav-link">Cards</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">Extended Cards</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">2.0</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</div>
