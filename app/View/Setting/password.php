<div class="container">
    <main class="text-light">
        <form action="/setting/password" method="post">

            <!-- Modal -->
            <div class="d-flex align-items-center vh-100">
                <div class="row card-body align-items-center justify-content-center">
                    <div class="col-md-5">

                        <?php if (isset($model['error'])) { ?>
                            <div class="mb-3  fw-bold text-center" role="alert">
                                <?= $model['error'] ?>
                            </div>
                        <?php } ?>

                        <div class="card p-2 bg-dark">
                            <div class="col-md-12 col-lg-9 order-first"><a class="link-dark" href="/setting/account"><i
                                            class="fa-solid fa-arrow-left fs-5 text-info"></i></a>
                            </div>
                            <div class="card-header border-info bg-dark">
                                <h1 class="fs-5" id="passwordModalLabel">Update Password</h1>
                            </div>
                            <div class="card-body bg-dark">
                                <div class="col-sm-12">

                                    <label class="form-label" for="oldPass">Old Password</label>
                                    <input class="form-control border-info bg-info bg-opacity-25 text-light mb-3 "
                                           id="oldPass" required type="password" name="oldPassword" autofocus>

                                    <label class="form-label" for="newPass">New Password</label>
                                    <input class="form-control border-info bg-info bg-opacity-25 text-light"
                                           id="newPass" required type="password" name="newPassword">

                                </div>
                            </div>
                            <div class="card-footer border-info bg-dark gap-2 d-md-flex justify-content-md-end">
                                <a class="btn btn-outline-info btn-sm fw-bold" href="/setting/account">Cancel</a>
                                <button class="btn btn-outline-warning btn-sm fw-bold" type="submit">Save changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

