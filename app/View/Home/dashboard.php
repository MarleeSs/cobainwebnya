<header class="py-3 mb-3 border-bottom border-warning">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <div class="fs-4 text-info">Welcome <span class="fs-4 fw-bold"> <?= $model['user']['name'] ?></span></div>

        <div class="d-flex align-items-md-center">
            <form class="w-100 me-3" style="opacity: 0" disabled role="search">
                <fieldset disabled>
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                </fieldset>
            </form>
            <div class="flex-shrink-0 dropdown">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    <img src="<?= $model['resource']['images'] ?>Profile%20M.png" alt="mdo" width="39" height="39"
                         class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small shadow bg-warning">
                    <li><a class="dropdown-item " href="/setting/account">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="/user/logout">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>



