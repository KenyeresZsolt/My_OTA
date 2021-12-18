<div class="card p-3 m-5">
    <div class="jumbotron text-center">
        <h2>A tartalom megtekintéséhez bejelentkezés szükséges</h2>
    </div>
</div>

<?php if($params['isRegistration']) : ?>

    <?php if($params['info'] === "emptyValue"): ?>
        <div class="alert alert-danger p-3 m-5" style="max-width: 20rem;">
            Tölts ki minden mezőt!
        </div>
    <?php endif; ?>

    <form class="card p-3 m-5" style="max-width: 20rem;" action="/registration" method="POST">
        <div class="form-group">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="name" id="name" autocomplete="off">
                <label for="name">Név</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="email" name="email" id="email" autocomplete="off">
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="password" id="password" autocomplete="off">
                <label for="password">Jelszó</label>
            </div>
            <br>
            <button type="submit" class="btn btn-success form-control">Regisztráció</button>
            Van már felhasználói fiókod?
            <a href="/bejelentkezes">Jelentkezz be!</a>
        </div>
    </form>


<?php else: ?>
    <?php if($params['info'] === "invalidCredentials"): ?>
        <div class="alert alert-danger p-3 m-5" style="max-width: 20rem;">
            Helytelen bejelentkezési adatok
        </div>
    <?php endif; ?>

    <?php if($params['info'] === "registrationSuccessfull"): ?>
        <div class="alert alert-success p-3 m-5" style="max-width: 20rem;">
            Sikeres regisztráció. Jelentkezz be!
        </div>
    <?php endif; ?>

    <div class="align-item-center">
        <form class="card p-3 m-5" style="max-width: 20rem;" action="/login" method="POST">
        <div class="form-floating mb-3">
                <input class="form-control" type="email" name="email" id="email" autocomplete="off">
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="password" id="password" autocomplete="off">
                <label for="password">Jelszó</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary form-control">Bejelentkezés</button>
            Nincs még felhasználói fiókod?
            <a href="/bejelentkezes?isRegistration=1">Regisztrálj!</a>
        </form>
    </div>

<?php endif ?>



