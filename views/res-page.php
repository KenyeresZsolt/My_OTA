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
                <hr style="border: 1px dashed white">
                <h4>Lefoglalt szobák:</h4>
                <ul>
                    <?php foreach($params['unitsDescription'] as $unitDescription): ?>
                        <li><?= $unitDescription ?></li>
                    <?php endforeach;?>
                </ul>
                <?php if($params['priceDetails']['originalRoomPrice'] !== $params['priceDetails']['finalRoomPrice']): ?>
                    <p>Kedvezmények:</p>
                    <ul>
                        <?= $params['priceDetails']['childrenRoomDiscountValue']>0 ? "<li>Gyerekkedvezmény: <span class='badge rounded-pill bg-success'>-" . $params['priceDetails']['childrenRoomDiscountValue'] . " lej</span></li>" : "" ?>
                        <?= $params['priceDetails']['groupDiscountValue']>0 ? "<li>Csoportkedvezmény: <span class='badge rounded-pill bg-success'>-" . $params['priceDetails']['groupDiscountValue'] . " lej</span></li>" : "" ?>
                        <?= $params['priceDetails']['earlyBookingDiscountValue']>0 ? "<li>Early Booking kedvezmény: <span class='badge rounded-pill bg-success'>-" . $params['priceDetails']['earlyBookingDiscountValue'] . " lej</span></li>" : "" ?>
                        <?= $params['priceDetails']['lastMinuteDiscountValue']>0 ? "<li>Last Minute kedvezmény: <span class='badge rounded-pill bg-success'>-" . $params['priceDetails']['lastMinuteDiscountValue'] . " lej</span></li>" : "" ?>
                    </ul>
                <?php endif; ?>
                <h5>Összesen: <?=$params['priceDetails']['originalRoomPrice'] !== $params['priceDetails']['finalRoomPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . $params['priceDetails']['originalRoomPrice'] . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['finalRoomPrice'] . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['finalRoomPrice'] . " lej</span>" ?></h5>
                <hr style="border: 1px dashed white">
                <?php if(!empty($params['mealsDescription'])): ?>
                    <h4>Étkezés:</h4>
                    <ul>
                        <?php foreach($params['mealsDescription'] as $mealDescription): ?>
                            <li><?=$mealDescription?></li>
                        <?php endforeach;?>
                    </ul>
                    <?php if($params['priceDetails']['originalMealPrice'] !== $params['priceDetails']['finalMealPrice']): ?>
                    <p>Kedvezmények:</p>
                    <ul>
                        <?= $params['priceDetails']['childrenMealDiscountValue']>0 ? "<li>Gyerekkedvezmény: <span class='badge rounded-pill bg-success'>-" . $params['priceDetails']['childrenMealDiscountValue'] . " lej</span></li>" : "" ?>
                    </ul>
                <?php endif; ?>
                    <h5>Összesen: <?=$params['priceDetails']['originalMealPrice'] !== $params['priceDetails']['finalMealPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . $params['priceDetails']['originalMealPrice'] . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['finalMealPrice'] . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['finalMealPrice'] . " lej</span>" ?></h5>
                    <hr style="border: 1px dashed white">
                <?php endif; ?>
                <?php if(!is_null($params['wellnessDescription']) OR !empty($params['wellnessDescription'])): ?>
                    <h4>Wellness:</h4>
                    <ul>
                        <li><?=$params['wellnessDescription']?></li>
                    </ul>
                    <?php if($params['priceDetails']['originalWellnessPrice'] !== $params['priceDetails']['finalWellnessPrice']): ?>
                    <p>Kedvezmények:</p>
                    <ul>
                        <?= $params['priceDetails']['childrenWellnessDiscountValue']>0 ? "<li>Gyerekkedvezmény: <span class='badge rounded-pill bg-success'>-" . $params['priceDetails']['childrenWellnessDiscountValue'] . " lej</span></li>" : "" ?>
                    </ul>
                <?php endif; ?>
                    <h5>Összesen: <?=$params['priceDetails']['originalWellnessPrice'] !== $params['priceDetails']['finalWellnessPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . $params['priceDetails']['originalWellnessPrice'] . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['finalWellnessPrice'] . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['finalWellnessPrice'] . " lej</span>" ?></h5>
                    <hr style="border: 1px dashed white">
                <?php endif; ?>
                <h4>Fizetendő összeg: <?=$params['priceDetails']['totalOriginalPrice'] !== $params['priceDetails']['totalFinalPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . $params['priceDetails']['totalOriginalPrice'] . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['totalFinalPrice'] . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . $params['priceDetails']['totalFinalPrice'] . " lej</span>" ?></h4>
            </div>
        </div>
    </div>
</div>