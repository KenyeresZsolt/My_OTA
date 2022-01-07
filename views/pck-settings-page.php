<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "edit" ? "active" : "" ?>" data-bs-toggle="tab" href="/<?= $params['package']['slug']?>/beallitasok/adatok">Adatok</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "services" ? "active" : "" ?>" data-bs-toggle="tab" href="/<?= $params['package']['slug']?>/beallitasok/szolgaltatasok">Szolgáltatások</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "discounts" ? "active" : "" ?>" data-bs-toggle="tab" href="/<?= $params['package']['slug']?>/beallitasok/kedvezmenyek">Kedvezmények</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $params['activeTab'] === "rooms" ? "active" : "" ?>" data-bs-toggle="tab" href="/<?= $params['package']['slug']?>/beallitasok/szobak">Szobák</a>
    </li>
</ul>
<?php echo $params['settingsContent'] ?>