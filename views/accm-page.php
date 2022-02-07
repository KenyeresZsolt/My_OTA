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
            <div class="m-3 slideshow-container" style="max-width:35rem;height:20rem">
                <?php foreach($params['images'] as $image): ?>
                    <div class="mySlides" style="position:absolute">
                        <img src="<?=$image['path']?>" class="img-thumbnail" style="width:100%;vertical-align:middle">
                    </div>
                <?php endforeach; ?>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <script>
                var slideIndex = 1;
                showSlides(slideIndex);

                function plusSlides(n) {
                showSlides(slideIndex += n);
                }

                function currentSlide(n) {
                showSlides(slideIndex = n);
                }

                function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                if (n > slides.length) {slideIndex = 1}    
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active";
                }
            </script>
            <div class="p-3 col-md-5">
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
                    <div style="max-width: 13rem;">
                        <label for="checkin">Érkezés dátuma</label>
                        <input class="form-control" type="date" name="checkin" min="<?= date("Y-m-d"); ?>" value="<?= $params['values']['checkin'] ?? '' ?>" autocomplete="off"/>
                    </div>
                    <div style="max-width: 13rem;">
                        <label for="checkout">Távozás dátuma</label>
                        <input class="form-control" type="date" name="checkout" min="<?= date("Y-m-d"); ?>" value="<?= $params['values']['checkout'] ?? '' ?>" autocomplete="off"/>
                    </div>
                    <div style="max-width: 10rem;">
                        <label for="guests">Felnőttek</label>
                        <input class="form-control" type="number" name="adults" min="1" value="<?= $params['values']['adults'] ?? 1 ?>" autocomplete="off"/>
                    </div>
                    <div style="max-width: 10rem;">
                        <label for="guests">Gyerekek</label>
                        <input class="form-control" type="number" name="children" min="0" value="<?= $params['values']['children'] ?? 0 ?>" autocomplete="off"/>
                    </div>
                    <div class="col-2 align-self-center">
                    <button type="submit" formaction="/best-offer/<?= $params['accm']["id"] ?>" class="btn btn-sm btn-secondary float-end">Legjobb ajánlat</button>
                    </div>
                </div>
            </div>
        </div>
        <?php if($params['info'] === "emptyRooms"): ?>
            <div class="alert alert-danger mb-3 text-center" id="infoMessage">
                Válassz ki legalább egy szobát!
            </div>
        <?php elseif($params['info'] === "tooMuchRooms"): ?>
            <div class="alert alert-danger mb-3 text-center" id="infoMessage">
                Túl sok szobát választottál ki!
            </div>
        <?php elseif($params['info'] === "lowCapacity"): ?>
            <div class="alert alert-danger mb-3 text-center" id="infoMessage">
                Kevés férőhely. Válassz ki több szobát vagy kevesebb személyt!
            </div>
        <?php endif; ?>
        <div class="card border-primary mb-3">
            <div class="card-header">Árak</div>
            <div class="card-body ms-3">
                <table style="border-collapse:separate;border-spacing: 0 1rem;">
                    <?php foreach($params['units'] as $unit): ?>
                        <tr class="rounded <?= $params['values']['rooms'][$unit['id']]>0 ? "bg-success text-white" : "bg-light" ?> ">
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
                <button type="submit" formaction="/calculate-price/<?= $params['accm']["id"] ?>" class="btn btn-sm btn-secondary float-end">Ár számítása</button>
            </div>
        </div>
        <hr>
        <?php if($params['info'] === "calculatePrice" OR $params['info'] === "bestOffer"): ?>
            <?php if($params['info'] === "bestOffer"): ?>
                <div class="alert alert-success mb-3 text-center" id="infoMessage">
                    Ez a legjobb ajánlat számodra!
                </div>
            <?php endif; ?>
            <div class="card border-success bg-light mb-3" id="calcPrice">
                <div class="card-header">Ár becslése</div>
                <div class="card-body">
                    <h4>Szobák:</h4>
                    <ul>
                        <?php foreach($params['resDetails']['unitsDescription'] as $unitDescription): ?>
                            <li><?= $unitDescription ?></li>
                        <?php endforeach;?>
                    </ul>
                    <?php if($params['resDetails']['priceDetails']['originalRoomPrice'] !== $params['resDetails']['priceDetails']['finalRoomPrice']): ?>
                        <p>Kedvezmények:</p>
                        <ul>
                            <?= $params['resDetails']['priceDetails']['childrenRoomDiscountValue']>0 ? "<li>Gyerekkedvezmény: <span class='badge rounded-pill bg-success'>-" . round($params['resDetails']['priceDetails']['childrenRoomDiscountValue'], 2) . " lej</span></li>" : "" ?>
                            <?= $params['resDetails']['priceDetails']['groupDiscountValue']>0 ? "<li>Csoportkedvezmény: <span class='badge rounded-pill bg-success'>-" . round($params['resDetails']['priceDetails']['groupDiscountValue'], 2) . " lej</span></li>" : "" ?>
                            <?= $params['resDetails']['priceDetails']['earlyBookingDiscountValue']>0 ? "<li>Early Booking kedvezmény: <span class='badge rounded-pill bg-success'>-" . round($params['resDetails']['priceDetails']['earlyBookingDiscountValue'], 2) . " lej</span></li>" : "" ?>
                            <?= $params['resDetails']['priceDetails']['lastMinuteDiscountValue']>0 ? "<li>Last Minute kedvezmény: <span class='badge rounded-pill bg-success'>-" . round($params['resDetails']['priceDetails']['lastMinuteDiscountValue'], 2) . " lej</span></li>" : "" ?>
                        </ul>
                    <?php endif; ?>
                    <h5>Összesen: <?=$params['resDetails']['priceDetails']['originalRoomPrice'] !== $params['resDetails']['priceDetails']['finalRoomPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . round($params['resDetails']['priceDetails']['originalRoomPrice'], 2) . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['finalRoomPrice'], 2) . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . $params['resDetails']['priceDetails']['finalRoomPrice'] . " lej</span>" ?></h5>
                    <hr style="border: 1px dashed white">
                    <?php if(!empty($params['resDetails']['mealsDescription'])): ?>
                        <h4>Étkezés:</h4>
                        <ul>
                            <?php foreach($params['resDetails']['mealsDescription'] as $mealDescription): ?>
                                <li><?=$mealDescription?></li>
                            <?php endforeach;?>
                        </ul>
                        <?php if($params['resDetails']['priceDetails']['originalMealPrice'] !== $params['resDetails']['priceDetails']['finalMealPrice']): ?>
                            <p>Kedvezmények:</p>
                            <ul>
                                <?= $params['resDetails']['priceDetails']['childrenMealDiscountValue']>0 ? "<li>Gyerekkedvezmény: <span class='badge rounded-pill bg-success'>-" . round($params['resDetails']['priceDetails']['childrenMealDiscountValue'], 2) . " lej</span></li>" : "" ?>
                            </ul>
                        <?php endif; ?>
                        <h5>Összesen: <?=$params['resDetails']['priceDetails']['originalMealPrice'] !== $params['resDetails']['priceDetails']['finalMealPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . round($params['resDetails']['priceDetails']['originalMealPrice'], 2) . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['finalMealPrice'], 2) . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['finalMealPrice'], 2) . " lej</span>" ?></h5>
                        <hr style="border: 1px dashed white">
                    <?php endif; ?>
                    <?php if(!is_null($params['resDetails']['wellnessDescription']) OR !empty($params['resDetails']['wellnessDescription'])): ?>
                        <h4>Wellness:</h4>
                        <ul>
                            <li><?=$params['resDetails']['wellnessDescription']?></li>
                        </ul>
                        <?php if($params['resDetails']['priceDetails']['originalWellnessPrice'] !== $params['resDetails']['priceDetails']['finalWellnessPrice']): ?>
                        <p>Kedvezmények:</p>
                        <ul>
                            <?= $params['resDetails']['priceDetails']['childrenWellnessDiscountValue']>0 ? "<li>Gyerekkedvezmény: <span class='badge rounded-pill bg-success'>-" . round($params['resDetails']['priceDetails']['childrenWellnessDiscountValue'], 2) . " lej</span></li>" : "" ?>
                        </ul>
                    <?php endif; ?>
                        <h5>Összesen: <?=$params['resDetails']['priceDetails']['originalWellnessPrice'] !== $params['resDetails']['priceDetails']['finalWellnessPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . round($params['resDetails']['priceDetails']['originalWellnessPrice'], 2) . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['finalWellnessPrice'], 2) . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['finalWellnessPrice'], 2) . " lej</span>" ?></h5>
                        <hr style="border: 1px dashed white">
                    <?php endif; ?>
                    <h4>Végösszeg: <?=$params['resDetails']['priceDetails']['totalOriginalPrice'] !== $params['resDetails']['priceDetails']['totalFinalPrice'] ? "<span class='badge rounded-pill bg-secondary'><s>" . round($params['resDetails']['priceDetails']['totalOriginalPrice'], 2) . " lej</s></span> <span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['totalFinalPrice'], 2) . " lej</span>" : "<span class='badge rounded-pill bg-primary'>" . round($params['resDetails']['priceDetails']['totalFinalPrice'], 2) . " lej</span>" ?></h4>
                    <a href="/szallasok/<?=$params['accm']['slug'] ?>">
                        <button type="button" class="btn btn-sm btn-outline-danger float-end">Mégse</button>
                    </a>
                    <br>
                    <h6 class="text-center">&darr; Megfelel? Foglald le most! &darr;</h6>
                </div>
            </div>
            <hr>
        <?php endif; ?>
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