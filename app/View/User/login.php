<main class="form-signin m-auto">

    <div class="container py-5">
        <div class="text-light py-5 text-center">
            <img class="mb-4 rounded-circle" src="<?= $model['resource']['images'] ?>Profile%20M.png" alt=""
                 width="120"
                 height="120">
            <h1 class="h3 mb-3 text-light">Please Sign in </h1>
            <div class="col-lg-12 mx-auto">

                <form method="post" action="/user/login">

                    <!--        valid email-->
                    <?php if (isset($model['error'])) { ?>
                        <div class="mb-3 text-danger fw-bold" role="alert">
                            <?= $model['error'] ?>
                        </div>
                    <?php } ?>

                    <!--        valid username-->

                    <div class="form-floating">
                        <input name="username" type="text"
                               class="form-control bg-dark border-secondary text-info rounded-top <?php if (isset($model['error'])) {
                                   echo 'is-invalid text-info';
                               } ?>"
                               id="insertUsername" placeholder="Username" required
                               value="<?= $_POST['username'] ?? '' ?>" autofocus>
                        <label for="insertUsername">Username</label>
                    </div>

                    <div class="form-floating">
                        <input name="password" type="password"
                               class="form-control bg-dark border-secondary border-top-0 text-info <?php if (isset($model['error'])) {
                                   echo 'is-invalid text-info';
                               } ?>"
                               id="insertPassword" placeholder="Username" required>
                        <label for="insertUsername">Password</label>
                    </div>

                    <!--    End Register insert-->

                    <button class="w-100 btn btn-lg btn-outline-info" type="submit">Sign In</button>

                </form>

                <div class=" mt-3">
                    <a class="btn-link link-info" href="/">Back to home</a> Or
                    <a class="btn-link link-info" href="/user/register">Sign Up</a>
                </div>
            </div>
        </div>
    </div>


</main>


