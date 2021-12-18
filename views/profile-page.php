<div class="card container p-5 m-5">
    Név: <?= $params["user"]["name"] ?> <br>
    email: <?= $params["user"]["email"] ?> <br>
    Regisztrálás dátuma: <?= date("Y.m.d H:i:s",$params["user"]["createdAt"]) ?> <br>

    <?php if($params['isAdmin'] === "1"): ?>
        <a href="/felhasznalok">
            <button class="btn btn-sm btn-primary float-end">Felhasználók</button>
        </a>
    <?php endif; ?>
</div>