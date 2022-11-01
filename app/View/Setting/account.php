<div class="container">
    <main class="text-light">
        <div class="py-5 text-center">
            <img alt="" class="d-block mx-auto mb-4 rounded-circle"
                 src="<?= $model['resource']['images'] ?>Profile%20M.png" width="120" height="120">
            <h2>Account Settings</h2>
        </div>

        <div class="row g-5 justify-content-center align-content-center">

            <div class="col-md-12 col-lg-9 order-first"><a class="link-dark" href="/dashboard"><i
                            class="fa-solid fa-arrow-left fs-5 text-info"></i></a>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-4 order-md-last">

                <h4 class="mb-3 text-warning">Last Update</h4>

                <ul class="list-group mb-3">
                    <li class="list-group-item border-warning bg-transparent d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0 text-light">Register at</h6>
                        </div>
                        <span class="badge bg-light text-dark"><?= $model['user']['register_at'] ?></span>
                    </li>
                    <li class="list-group-item border-warning bg-transparent d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0 text-light">Email</h6>
                        </div>
                        <span class="badge bg-warning text-dark"><?= $model['user']['last_update_email'] ?? 'not changed' ?></span>
                    </li>
                    <li class="list-group-item border-warning bg-transparent d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0 text-light">Password</h6>
                        </div>
                        <span class="badge bg-warning text-dark"><?= $model['user']['last_update_password'] ?? 'not changed' ?></span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-5 order-1">

                <h4 class="mt-3 text-info">Information</h4>
                <div class="col-sm-12">
                    <fieldset disabled>
                        <label class="form-label" for="username">Your username</label>
                        <input class="form-control border-info bg-info bg-opacity-25 text-light fst-italic"
                               id="username" value="<?= $model['user']['username'] ?>">
                    </fieldset>
                </div>

                <hr class="mt-4">


                <form method="post" action="/setting/account">
                    <div class="col-sm-12">
                        <?php if (isset($model['error'])) { ?>
                            <div class="mb-3 text-danger fw-bold text-center" role="alert">
                                <?= $model['error'] ?>
                            </div>
                        <?php } ?>
                        <fieldset disabled>
                            <label class="form-label" for="yourEmail">Your Email</label>
                            <input class="form-control border-info bg-info bg-opacity-25 text-light fst-italic"
                                   id="yourEmail" value="<?= $model['user']['email'] ?>">
                        </fieldset>

                        <button class="btn btn-outline-light fw-bold btn-sm mt-3" data-bs-target="#emailModal"
                                data-bs-toggle="modal"
                                type="button">
                            Change Email
                        </button>

                        <!-- Modal -->
                        <div aria-hidden="true" aria-labelledby="emailModalLabel" class="modal fade" id="emailModal"
                             tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-transparent">
                                    <div class="modal-header border-info bg-dark">
                                        <h1 class="modal-title fs-5" id="emailModalLabel">Update Email</h1>
                                        <button aria-label="Close" class="btn-close-white"
                                                data-bs-dismiss="modal"
                                                type="button"></button>
                                    </div>
                                    <div class="modal-body bg-dark">
                                        <div class="col-sm-12">

                                            <label class="form-label" for="newEmail">New Email</label>
                                            <input class="form-control border-info bg-info bg-opacity-25 text-light <?php if (isset($model['error'])) {
                                                echo 'is-invalid';
                                            } ?>"
                                                   id="newEmail" required type="email" autofocus name="email">

                                        </div>
                                    </div>
                                    <div class="modal-footer border-info bg-dark">
                                        <a class="btn btn-outline-info fw-bold" href="/setting/account">Cancel</a>
                                        <button class="btn btn-outline-warning fw-bold" type="submit">Save
                                            changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <hr class="my-4">
                <div class="col-12 mb-3">

                    <h6>Update Password</h6>

                    <!-- Button trigger modal -->
                    <a href="/setting/password" class="btn btn-outline-warning fw-bold btn-sm mt-3">
                        Change Password
                    </a>

                    <!-- Modal -->
                </div>
            </div>
        </div>
    </main>
</div>

