<?php if($params['isRegistration']) : ?>

    <?php if($params['info'] === "emptyValue"): ?>
        <a href="/bejelentkezes?isRegistration=1" style="text-decoration:none">
            <div class="row">
                <div class="ms-auto me-auto alert alert-danger p-2 text-center" style="max-width: 25rem;">
                    Tölts ki minden mezőt!
                </div>
            </div>
        </a>
    <?php endif; ?>
    <div class="row">
        <div class="card p-3 border-success ms-auto me-auto" style="max-width: 25rem;">
            <h2 class="text-center">Regisztrálj!</h2>
            <br>
            <form action="/registration" method="POST">
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
                    <br>
                    <br>
                    Van már felhasználói fiókod?
                    <a href="/bejelentkezes">Jelentkezz be!</a>
                </div>
            </form>
        </div>
    </div>


<?php else: ?>
    <?php if($params['info'] === "invalidCredentials"): ?>
        <a href="/bejelentkezes" style="text-decoration:none">
            <div class="row">
                <div class="ms-auto me-auto alert alert-danger p-2 text-center" style="max-width: 25rem;">
                    Helytelen bejelentkezési adatok
                </div>
            </div>
        </a>
    <?php endif; ?>

    <?php if($params['info'] === "registrationSuccessfull"): ?>
        <a href="/bejelentkezes" style="text-decoration:none">
            <div class="row">
                <div class="ms-auto me-auto alert alert-success p-2 text-center" style="max-width: 25rem;">
                    Sikeres regisztráció. Jelentkezz be!
                </div>
            </div>
        </a>
    <?php endif; ?>
    <?php if($params['info'] === "emailUsed"): ?>
        <a href="/bejelentkezes" style="text-decoration:none">
            <div class="row">
                <div class="ms-auto me-auto alert alert-danger p-2 text-center" style="max-width: 25rem;">
                    Ezzel az emailcímmel már regisztrálva vagy. Jelentkezz be!
                </div>
            </div>
        </a>
    <?php endif; ?>
    <div class="row">
        <div class="card p-3 border-success ms-auto me-auto" style="max-width: 25rem;">
            <form action="/login" method="POST">
                <h2 class="text-center">Jelentkezz be!</h2>
                <br>
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
                <br>
                <br>
                Nincs még felhasználói fiókod?
                <a href="/bejelentkezes?isRegistration=1">Regisztrálj!</a>
            </form>
        </div>
    </div>
<?php endif ?>