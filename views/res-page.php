<div class="card border-success mb-3 m-5">
    <div class="card-header">Azonosító: <?= $params['reservation']['id']?></div>
    <div class="card-body">
        <div class="card border-success mb-3 m-3">
            <div class="card-header"><?= $params['reservation']['accm_name'] . " " . $params['reservation']['location']?></div>
            <div class="card-body">
                <div class="row">
                    <div class="m-3" style="max-width:20vw">
                        <img src="<?=$params['image']['path']?>" class="img-thumbnail" style="width:100%;vertical-align:middle">
                    </div>
                    <div class="p-3 col-md-3">
                        <div class="card border-primary mb-3">
                            <div class="card-header">Cím</div>
                            <div class="card-body ms-3">
                                <div class="row"><?=$params['reservation']['location']?></div>
                                <div class="row"><?=(!empty($params['address']['street']) ? $params['address']['street'] . " utca" : "") . (!empty($params['address']['number']) ? ", " . $params['address']['number'] . " szám" : "") . (!empty($params['address']['building']) ? ", " . $params['address']['building'] . " épület" : "") . (!empty($params['address']['floor']) ? ", " . $params['address']['floor'] . " emelet" : "") . (!empty($params['address']['door']) ? ", " . $params['address']['door'] . " ajtó" : "")?></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 col-md-5">
                        <div class="card border-primary mb-3">
                            <div class="card-header">Elérhetőségek</div>
                            <div class="card-body ms-3">
                                <div class="row">Kapcsolattartó neve: <?=$params['reservation']['contact_name']?></div><br>
                                <div class="row">Email: <?=$params['reservation']['contact_email']?></div>
                                <div class="row">Telefonszám: <?=$params['reservation']['contact_phone']?></div>
                                <div class="row">Weboldal: <?=$params['reservation']['contact_webpage']?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-success mb-3 m-3">
            <div class="card-header">Vendég adatai</div>
            <div class="card-body">
                <ul>
                    <li>Név: <?= $params['reservation']['name'] ?></li>
                    <li>Emailcím: <?= $params['reservation']['email'] ?></li>
                    <li>Telefonszám: <?= $params['reservation']['phone'] ?></li>
                </ul>
            </div>
        </div>
        <div class="card border-success mb-3 m-3">
            <div class="card-header">Foglalás részletei</div>
            <div class="card-body">
                <ul>
                    <li>Bejelentkezés: <?= $params['reservation']['checkin'] ?></li>
                    <li>Kijelentkezés: <?= $params['reservation']['checkout'] ?></li>
                    <li><?= $params['reservation']['adults'] . " felnőtt"?><?= $params['reservation']['children']>0 ? " és " . $params['reservation']['children'] . " gyerek" : ""?></li>
                    <li><?= $params['reservation']['nights'] ?> éjszaka</li>
                </ul>
                <p>Lefoglalt szobák:</p>
                <ul>
                    <?php foreach($params['unitsDescription'] as $unitDescription): ?>
                        <li><?= $unitDescription ?></li>
                    <?php endforeach;?>
                </ul>
                <?php if(!empty($params['mealsDescription'])): ?>
                    <p>Étkezés:</p>
                    <ul>
                        <?php foreach($params['mealsDescription'] as $mealDescription): ?>
                            <li><?=$mealDescription?></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
                <?php if(!is_null($params['wellnessDescription']) OR !empty($params['wellnessDescription'])): ?>
                    <p>Wellness:</p>
                    <ul>
                        <li><?=$params['wellnessDescription']?></li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>