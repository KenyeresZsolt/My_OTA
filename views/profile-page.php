<p><b>Név:</b> <?= $params["user"]["name"] ?></p>
<p><b>email:</b> <?= $params["user"]["email"] ?></p>
<p><b>Regisztráció dátuma:</b> <?= date("Y.m.d H:i:s",$params["user"]["registered"]) ?></p>
<p><b>Utolsó módosítás:</b> <?= $params["user"]["last_modified"] === "0" ? "soha" : date("Y.m.d H:i:s",$params["user"]["last_modified"]) ?></p>
<?php if($params['isAdmin'] === "1"): ?>
    <div>
            <a href="/felhasznalok" class="btn btn-sm btn-primary float-end">Felhasználók</a>
    </div>
    <br>
<?php endif; ?>
<?php if($params['info'] === "updateSuccessfull"): ?>
    <a href="/profil" style="text-decoration:none">
        <div class="alert alert-success text-center">
            Módosítások lementve
        </div>
    </a>
<?php elseif($params['info'] === "emailUsed"): ?>
    <a href="/profil" style="text-decoration:none">
        <div class="alert alert-danger text-center">
            Létező emailcím
        </div>
    </a>
<?php elseif($params['info'] === "invalidPassword"): ?>
    <a href="/profil" style="text-decoration:none">
        <div class="alert alert-danger text-center">
            Érvénytelen jelszó
        </div>
    </a>
<?php elseif($params['info'] === "notIdenticalPassword"): ?>
    <a href="/profil" style="text-decoration:none">
        <div class="alert alert-danger text-center">
            Új jelszó nem egyezik
        </div>
    </a> 
<?php endif ?>
<div class="card border-primary mb-3">
    <div class="card-header">Adatok módosítása</div>
        <div class="card-body">
            <form class="form-inline" action="/update-profil" method="POST" id="updtProfile">
                <div class="form-group">
                    <div class="row">
                        <div style="max-width: 15rem;">
                            <label for="name">Név</label>
                            <input class="form-control" type="text" name="name" value="<?= $params['user']['name'] ?? '' ?>" autocomplete="off"/>                                        
                        </div>
                        <div style="max-width: 20rem;">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email" value="<?= $params['user']['email'] ?? '' ?>" autocomplete="off"/>                                        
                        </div>
                        <div style="max-width: 15rem;">
                            <label for="phone">Telefonszám</label>
                            <input class="form-control" type="text" name="phone" value="<?= $params['user']['phone'] ?? '' ?>" autocomplete="off"/>                                        
                        </div>
                    </div>
                    <br>
                    <p><b>Jelszó módosítása:</b></p>
                    <div class="row">
                        <div style="max-width: 15rem;">
                            <label for="name">Jelenlegi jelszó</label>
                            <input class="form-control" type="password" name="oldPassword" autocomplete="off"/>                                        
                        </div>
                        <div style="max-width: 15rem;">
                            <label for="name">Új jelszó</label>
                            <input class="form-control" type="password" name="newPassword" autocomplete="off"/>                                        
                        </div>
                        <div style="max-width: 15rem;">
                            <label for="name">Új jelszó megerősítése</label>
                            <input class="form-control" type="password" name="newPassword2" autocomplete="off"/>                                        
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="btn-group float-end">
                        <button type="submit" class="btn btn-sm btn-success">Mentés</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>