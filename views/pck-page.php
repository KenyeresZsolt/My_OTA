<a href="/csomagok">
    <button class="btn btn-sm btn-outline-success">Vissza</button>
</a>
<br>
<?php if($params['info'] === "updated"): ?>
    <div class="alert alert-success">
        Csomag frissítve!
    </div>
<?php elseif($params["info"] === "reserved"): ?>
    <div class="alert alert-success">
        Sikeres foglalás!
    </div>
<?php endif ?>
<div class="card border-primary mb-3" id="<?= $params['package']['id']?>">
    <div class="card-header">
        <div class="row">
            <div class="h4 col-md-10">
                <?= $params['package']['name'] . " " . $params['package']['location'];?>
            </div>
            <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                <div class="btn-group float-end col-md-2">
                    <a href="/csomagok/<?= $params['package']["slug"] ?>?addimage=1#addImg">
                        <button class="btn btn-sm btn-light float-end">+kép</button>
                    </a>

                    <a href="/<?= $params['package']["slug"] ?>/szerkesztes">
                        <button class="btn btn-sm btn-light float-end">Szerkesztés</button>
                    </a>
                        
                    <form action="/delete-package/<?= $params['package']["id"] ?>" method="post">
                        <button type="submit" class="btn btn-sm btn-danger float-end">Törlés</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="p-3" style="max-width:55rem">
                <?php if(isset($params['package']['image'])): ?>
                    <img class="img-thumbnail" src="<?= $params['package']['image']?>" alt="<?= $params['package']['name'] ?>" style="width:100%">
                <?php endif; ?>
            </div>
            <div class="p-3 col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-header">Cím</div>
                    <div class="card-body ms-3">
                        <div class="row"><?=$params['package']['location']?></div>
                        <div class="row"><?=(!empty($params['address']['street']) ? $params['address']['street'] . " utca" : "") . (!empty($params['address']['number']) ? ", " . $params['address']['number'] . " szám" : "") . (!empty($params['address']['building']) ? ", " . $params['address']['building'] . " épület" : "") . (!empty($params['address']['floor']) ? ", " . $params['address']['floor'] . " emelet" : "") . (!empty($params['address']['door']) ? ", " . $params['address']['door'] . " ajtó" : "")?></div>
                    </div>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">Elérhetőségek</div>
                    <div class="card-body ms-3">
                        <div class="row">Kapcsolattartó neve: <?=$params['package']['contact_name']?></div><br>
                        <div class="row">Email: <?=$params['package']['email']?></div>
                        <div class="row">Telefonszám: <?=$params['package']['phone']?></div>
                        <div class="row">Weboldal: <?=$params['package']['webpage']?></div>
                    </div>
                </div>
            </div>
        </div>
        <br>       
        <div class="card border-primary mb-3">
            <div class="card-header">Árak</div>
            <div class="card-body ms-3">
                <div class="row">Szállás: <?= @$params['package']['price'];?> RON/fő/éj</div>
                <div class="row">Reggeli: <?= @$params['package']['breakfast_price'];?> RON/fő/alkalom</div>
            </div>
        </div>
        <hr>
        <?php if($params['info'] === "emptyValue"): ?>
            <div class="alert alert-danger mb-3" style="max-width: 20rem;" id="infoMessage">
                Tölts ki minden mezőt!
            </div>
        <?php endif; ?>
        <div class="card border-success bg-light mb-3">
            <div class="card-header">Küldd el foglalásod most!</div>
            <div class="card-body">
                <p class="card-title">Add meg az adataidat:</p>
                <form class="form-inline" action="/reserve-package/<?= $params['package']["id"] ?>" method="POST" id="resForm">
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
                            <div style="max-width: 15rem;">
                                <label for="guests">Személyek száma</label>
                                <input class="form-control" type="number" name="guests" min="1" value="<?= $params['values']['guests'] ?? '' ?>" autocomplete="off"/>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div style="max-width: 15rem;">
                                <label for="checkin">Érkezés dátuma</label>
                                <input class="form-control" type="date" name="checkin" min="<?= date("Y-m-d"); ?>" value="<?= $params['values']['checkin'] ?? '' ?>" autocomplete="off"/>
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="checkout">Távozás dátuma</label>
                                <input class="form-control" type="date" name="checkout" min="<?= date("Y-m-d"); ?>" value="<?= $params['values']['checkout'] ?? '' ?>" autocomplete="off"/>
                            </div>
                        </div>
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
                <div class="row"><?= "Típus: " . $params['package']['type']?></div>
                <div class="row"><?= "Férőhelyek: " . $params['package']['capacity'] . " személy (" . $params['package']['rooms'] . " szoba)"?></div>
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
                <p class="row justify-content-between"><?= @$params['package']['description']; ?></p>
            </div>
        </div>
        
        <?php if($params["addImgToPckId"]): ?>
            <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                <form action="/upload-pck-image/<?= $params['package']["id"] ?>" method="post" enctype="multipart/form-data" id="addImg">
                    <input class="form-control col-md-2" type="file" name="fileToUpload" id="fileToUpload">
                    <br>
                    <input class="btn btn-sm btn-success" type="submit" value="Feltöltés" name="submit">
                    <a href="/csomagok/<?= $params['package']["slug"]?>">
                        <button type="button" class="btn btn-sm btn-outline-primary mr-2">Mégse</button>
                    </a>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>