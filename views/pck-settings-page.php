<a href="/csomagok/<?= $params['package']['slug']?>">
    <button type="button" class="btn btn-sm btn-outline-secondary mr-2 float-end">Vissza</button>
</a>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "pckPage" ? "active" : "" ?>" data-bs-toggle="tab" href="/csomagok/<?= $params['package']['slug']?>"><?= $params['package']['name']?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "edit" ? "active" : "" ?>" data-bs-toggle="tab" href="/csomagok/<?= $params['package']['slug']?>/beallitasok/adatok">Adatok</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "services" ? "active" : "" ?>" data-bs-toggle="tab" href="/csomagok/<?= $params['package']['slug']?>/beallitasok/szolgaltatasok">Szolgáltatások</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "discounts" ? "active" : "" ?>" data-bs-toggle="tab" href="/csomagok/<?= $params['package']['slug']?>/beallitasok/kedvezmenyek">Kedvezmények</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "rooms" ? "active" : "" ?>" data-bs-toggle="tab" href="/csomagok/<?= $params['package']['slug']?>/beallitasok/szobak">Szobák</a>
    </li>
</ul>
<?php echo $params['settingsContent'] ?>
<div class="mb-3 m-5">
    <small>Utoljára szerkesztve ekkor: <b><?= $params['package']['last_modified'] === "0" ? "soha" : date("Y.m.d H:i:s", $params['package']['last_modified'])?></b></small><br>
    <small>Utoljára szerkesztette: <b><?= $params['package']['modified_by_user_name']?></b></small>
</div>