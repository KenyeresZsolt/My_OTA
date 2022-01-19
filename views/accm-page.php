<?php if($params["info"] === "reserved"): ?>
    <a href="/szallasok/<?= $params['accm']['slug']?>" style="text-decoration:none">
        <div class="alert alert-success text-center">
            Sikeres foglalás!
        </div>
    </a>
<?php endif ?>
<div class="card border-primary mb-3 m-5" id="<?= $params['accm']['id']?>">
    <div class="card-header">
        <div class="row">
            <div class="h4 col-md-10">
                <?= $params['accm']['name'] . " " . $params['accm']['location'];?>
            </div>
            <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                <div class="btn-group float-end col-2">
                    <a href="/szallasok/<?= $params['accm']["slug"] ?>/beallitasok/adatok">
                        <button class="btn btn-sm btn-light float-end">Beállítások</button>
                    </a>
                    <form action="/delete-accm/<?= $params['accm']["id"] ?>" method="post">
                        <button type="submit" class="btn btn-sm btn-danger float-end">Törlés</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="p-3" style="max-width:50vw">
                <?php if(isset($params['accm']['image'])): ?>
                    <img class="img-thumbnail" src="<?= $params['accm']['image']?>" alt="<?= $params['accm']['name'] ?>" style="width:100%">
                <?php endif; ?>
            </div>
            <div class="p-3 col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-header">Cím</div>
                    <div class="card-body ms-3">
                        <div class="row"><?=$params['accm']['location']?></div>
                        <div class="row"><?=(!empty($params['address']['street']) ? $params['address']['street'] . " utca" : "") . (!empty($params['address']['number']) ? ", " . $params['address']['number'] . " szám" : "") . (!empty($params['address']['building']) ? ", " . $params['address']['building'] . " épület" : "") . (!empty($params['address']['floor']) ? ", " . $params['address']['floor'] . " emelet" : "") . (!empty($params['address']['door']) ? ", " . $params['address']['door'] . " ajtó" : "")?></div>
                    </div>
                </div>
                <hr>
                <div class="card border-primary mb-3">
                    <div class="card-header">Elérhetőségek</div>
                    <div class="card-body ms-3">
                        <div class="row">Kapcsolattartó neve: <?=$params['accm']['contact_name']?></div><br>
                        <div class="row">Email: <?=$params['accm']['email']?></div>
                        <div class="row">Telefonszám: <?=$params['accm']['phone']?></div>
                        <div class="row">Weboldal: <?=$params['accm']['webpage']?></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <?php if($params['info'] === "emptyData"): ?>
            <div class="alert alert-danger mb-3 text-center" id="infoMessage">
            Tölts ki minden mezőt!
            </div>
        <?php endif; ?>
        <div class="card border-primary mb-3">
            <div class="card-header">Utazás részletei</div>
            <div class="card-body ms-3">
            <form class="form-inline" action="/reserve-accm/<?= $params['accm']["id"] ?>" method="POST" id="resForm">
                <div class="row">
                    <div style="max-width: 15rem;">
                        <label for="checkin">Érkezés dátuma</label>
                        <input class="form-control" type="date" name="checkin" min="<?= date("Y-m-d"); ?>" value="<?= $params['values']['checkin'] ?? '' ?>" autocomplete="off"/>
                    </div>
                    <div style="max-width: 15rem;">
                        <label for="checkout">Távozás dátuma</label>
                        <input class="form-control" type="date" name="checkout" min="<?= date("Y-m-d"); ?>" value="<?= $params['values']['checkout'] ?? '' ?>" autocomplete="off"/>
                    </div>
                    <div style="max-width: 15rem;">
                        <label for="guests">Felnőttek</label>
                        <input class="form-control" type="number" name="adults" min="1" value="<?= $params['values']['adults'] ?? 1 ?>" autocomplete="off"/>
                    </div>
                    <div style="max-width: 15rem;">
                        <label for="guests">Gyerekek</label>
                        <input class="form-control" type="number" name="children" min="0" value="<?= $params['values']['children'] ?? 0 ?>" autocomplete="off"/>
                    </div>
                </div>
            </div>
        </div>
        <?php if($params['info'] === "emptyRooms"): ?>
            <div class="alert alert-danger mb-3 text-center" id="infoMessage">
                Válassz ki legalább egy szobát!
            </div>
        <?php endif; ?>
        <div class="card border-primary mb-3">
            <div class="card-header">Árak</div>
            <div class="card-body ms-3">
                <table style="border-collapse:separate;border-spacing: 0 1rem;">
                    <?php foreach($params['units'] as $unit): ?>
                        <tr class="bg-light rounded">
                            <td style="width: 5rem;">
                                <input class="form-control m-1" type="number"  name="rooms[<?= $unit['id']?>]" value="<?= $params['values']['rooms'][$unit['id']] ?? 0 ?>" min="0" max="<?= $unit['count']?>">
                            </td>
                            <td style="width: 40rem;">
                                <div class="ms-3"><?= $unit['name']?></div>
                            </td>
                            <td class="text-center" style="width: 20rem;">
                                <?= $unit['price']?> RON
                            </td>
                            <td class="text-center small" style="width: 20rem;">
                                <?= $unit['capacity_per_unit']?> főnek, 1 éjszakára
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    <?php foreach($params['meals'] as $meal): ?>
                        <?php if($params['accm']['meal_offered'] === "YES" AND $params['accm'][$meal['value']] !== "NOTPROVIDED"): ?>
                            <tr class="bg-light">
                                <td class="text-center" style="width: 5rem;">
                                    <input class="form-check-input m-1" type="checkbox"  name="meals[]" value="<?= $meal['value']?>" <?= ($params['accm'][$meal['value']] === "INPRICE" ? "checked disabled" : ($params['accm'][$meal['value']] === "ALACARTE" ? "disabled" : (@in_array($meal['value'], $params['values']['meals']) ? "checked" : ''))) ?>>
                                </td>
                                <td style="width: 40rem;">
                                    <div class="ms-3"><?= $meal['name']?></div>
                                </td>
                                <td class="text-center" style="width: 20rem;">
                                    <?php if($params['accm'][$meal['value']] === 'PAYABLE'): ?>
                                        <?= $params['accm'][$meal['value'] . "_price"] . " RON"?>
                                    <?php else: ?>
                                        <?= $params['accm'][$meal['value'] . "_hu_status"]?>
                                    <?php endif; ?>
                                </td>
                                <td  class="text-center small" style="width: 20rem;">1 fő, 1 nap</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if($params['accm']['wellness_offered'] === "YES"): ?>
                        <tr class="bg-light rounded">
                        <td class="text-center" style="width: 5rem;">
                            <input class="form-check-input m-1" type="checkbox"  name="wellness" value="YES" <?= ($params['accm']['wellness_status'] === "INPRICE" ? "checked disabled": (isset($params['values']['wellness']) ? "checked" : "")) ?>>
                        </td>
                        <td style="width: 40rem;">
                            <div class="ms-3">Wellness: <?= implode(" + ", $params['wellnessFacilityNames']) ?></div>
                        </td>
                        <td class="text-center" style="width: 20rem;">
                            <?= $params['accm']['wellness_status'] === "INPRICE"? "Benne van az árban" : $params['accm']['wellness_price'] . " RON"?>
                        </td>
                        <td  class="text-center small" style="width: 20rem;">1 fő, 1 nap</td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        <hr>
        <?php if($params['info'] === "emptyContact"): ?>
            <div class="alert alert-danger mb-3 text-center" id="infoMessage">
                Add meg az adataidat!
            </div>
        <?php endif; ?>
        <div class="card border-success bg-light mb-3">
            <div class="card-header">Küldd el foglalásod most!</div>
            <div class="card-body">
                <p class="card-title">Add meg az adataidat:</p>
                    <div class="form-group">
                        <div class="row">
                            <div style="max-width: 15rem;">
                                <label for="name">Név</label>
                                <input class="form-control" type="text" name="name" value="<?= $params['values']['name'] ?? '' ?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="email">Email</label>
                                <input class="form-control" type="text" name="email" value="<?= $params['values']['email'] ?? '' ?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="phone">Telefonszám</label>
                                <input class="form-control" type="text" name="phone" value="<?= $params['values']['phone'] ?? '' ?>" autocomplete="off"/>                                        
                            </div>
                        </div>
                        <br>
                    </div>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-sm btn-success float-end">Lefoglalom</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="card border-primary mb-3">
            <div class="card-header">Szálláshely adatai</div>
            <div class="card-body ms-3">
                <div class="row"><?= "Típus: " . $params['accm']['type']?></div>
                <div class="row"><?= "Férőhelyek: " . $params['accm']['capacity'] . " személy (" . $params['accm']['rooms'] . " szoba, " . $params['accm']['bathrooms'] . " fürdőszoba)"?></div>
                <hr style="border: 1px dashed white;width:15rem">
                <div class="row">Beszélt nyelvek:
                    <?php if(!empty($params['languages'])){
                        foreach($params['languages'] as $language){
                            foreach($params['accmLangs'] as $accmLang){
                                if($accmLang['code'] === $language){
                                    $accmLangs[] = $accmLang['name'];
                                }
                            }
                        }
                        echo implode(", ", $accmLangs);
                    }?>

                </div>
            </div>
        </div>
        <hr>
        <div class="card border-primary mb-3">
            <div class="card-header">Kedvezmények</div>
            <div class="card-body ms-3">
                <?php if($params['discounts']['children_discount'] === "YES"): ?>
                    Gyermekkedvezmény: 
                    <ul>
                        <li><?= $params['discounts']['children_discount_percent'] . "%"?></li>
                    </ul>
                    Erre alkalmazható: 
                    <ul>
                        <?= $params['discounts']['children_discount_for_accm'] === "YES" ? "<li>szállás</li>" : "" ?>
                        <?= $params['discounts']['children_discount_for_meals'] === "YES" ? "<li>étkezés</li>" : "" ?>
                        <?= $params['discounts']['children_discount_for_wellness'] === "YES" ? "<li>wellness</li>" : "" ?>
                    </ul>               
                <?php endif; ?>
                <?php if($params['discounts']['group_discount'] === "YES"): ?>
                    <hr style="border: 1px dashed white;width:15rem">
                    Csoportkedvezmény:
                    <ul>
                        <li><?= $params['discounts']['group_discount_percent'] . "%" ?></li>
                        <li><?= $params['discounts']['group_person_number'] . " fő felett" ?></li>
                    </ul>
                <?php endif; ?>
                <?php if($params['discounts']['early_booking_discount'] === "YES"): ?>
                    <hr style="border: 1px dashed white;width:15rem">
                    Early Booking kedvezmény:
                    <ul>
                        <li><?= $params['discounts']['early_booking_discount_percent'] . "%" ?></li>
                        <li><?= "Érkezés előtt min. " . $params['discounts']['early_booking_days'] . " nappal történő foglalás esetén" ?></li>
                    </ul>
                <?php endif; ?>
                <?php if($params['discounts']['last_minute_discount'] === "YES"): ?>
                    <hr style="border: 1px dashed white;width:15rem">
                    Last Minute kedvezmény:
                    <ul>
                        <li><?= $params['discounts']['last_minute_discount_percent'] . "%" ?></li>
                        <li><?= "Érkezés előtt max. " . $params['discounts']['last_minute_days'] . " nappal történő foglalás esetén" ?></li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <div class="card border-primary mb-3">
            <div class="card-header">Szolgáltatások és felszereltség</div>
            <div class="card-body ms-3">
                <ul>
                    <?php if(!empty($params['facilities'])){
                        foreach($params['facilities'] as $facility){
                            foreach($params['accmFacilities'] as $accmFacility){
                                if($accmFacility['facility_code'] === $facility){
                                    echo "<li>" . $accmFacility['name'] . "</li>";
                                }
                            }
                        }
                    }?>
                </ul>
            </div>
        </div>
        <hr>
        <div class="card border-primary mb-3">
            <div class="card-header">Leírás</div>
            <div class="card-body ms-3">
                <p class="row justify-content-between"><?= @$params['accm']['description']; ?></p>
            </div>
        </div>
    </div>
</div>