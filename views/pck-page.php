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
    <h4><div class="card-header"><?= $params['package']['name'] . " " . $params['package']['location'];?> </div></h4>
    <div class="card-body container">
        <div class="row">
            <?php if(isset($params['package']['image'])): ?>
                <img src="<?= $params['package']['image']?>" alt="<?= $params['package']['name'] ?>" style="width:50%" class="align-right">
            <?php endif; ?>
            <div class="col-md-6">
                <div class="container">
                <h4 class="row">Szállás címe</h4>
                    <div class="row"><?=$params['package']['location']?></div>
                    <div class="row"><?=$params['address']['street'] . (!empty($params['address']['street']) ? " utca" : "") . (!empty($params['address']['number']) ? ", " . $params['address']['number'] . " szám" : "") . (!empty($params['address']['building']) ? ", " . $params['address']['building'] . " épület" : "") . (!empty($params['address']['floor']) ? ", " . $params['address']['floor'] . " emelet" : "") . (!empty($params['address']['door']) ? ", " . $params['address']['door'] . " ajtó" : "")?></div>
                </div>
                <hr>
                <div class="container">
                    <h4 class="row">Leírás</h4>
                    <p class="row justify-content-between"><?= @$params['package']['description']; ?></p>
                </div>
                <hr>
            </div>
        </div>
        <br>       
        <div class="container">
            <h4 class="row">Árak</h4>
            <div class="row">Szállás: <?= @$params['package']['price'];?> RON/fő/éj</div>
            <div class="row">Reggeli: <?= @$params['package']['breakfast_price'];?> RON/fő/alkalom</div>
        </div>
        <hr>
        <div class="container">
            <h4 class="row">Szálláshely adatai</h4>
            <div class="row"><?= "Típus: " . $params['package']['type']?></div>
            <div class="row"><?= "Férőhelyek: " . $params['package']['capacity'] . " (" . $params['package']['rooms'] . " szoba)"?></div>
            <hr style="border: 1px dashed white;width:15rem">
            <div class="row">Beszélt nyelvek:
                <?php foreach($params['languages'] as $language){
                    foreach($params['accmsLangs'] as $accmsLang){
                        if($accmsLang['code'] === $language){
                            echo $accmsLang['name'] . ", ";
                        }
                    }
                } ?>

            </div>
        <br>
        <br>
        
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
        
        <?php elseif($params["resPackageId"]): ?>
            <?php if($params['info'] === "emptyValue"): ?>
                <div class="alert alert-danger mb-3" style="max-width: 20rem;" id="infoMessage">
                    Tölts ki minden mezőt!
                </div>
            <?php endif; ?>
            <div class="card border-success mb-3">
                <div class="card-header">Küldd el foglalásod most! </div>
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
                        <br>
                        <br>
                        <div class="btn-group float-end">
                            <a href="/csomagok/<?= $params['package']["slug"]?>">
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2">Vissza</button>
                            </a>

                            <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                        </div> 
                    </form>
                </div>
            </div>
        

        <?php else: ?>
        
            <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                <div class="btn-group">
                    <a href="/csomagok/<?= $params['package']["slug"] ?>?addimage=1#addImg">
                        <button class="btn btn-sm btn-light">Kép hozzáadása</button>
                    </a>

                    <a href="/<?= $params['package']["slug"] ?>/szerkesztes">
                        <button class="btn btn-sm btn-light">Szerkesztés</button>
                    </a>
                        
                    <form action="/delete-package/<?= $params['package']["id"] ?>" method="post">
                        <button type="submit" class="btn btn-sm btn-danger">Törlés</button>
                    </form>
                </div>
            <?php endif; ?>
                <a href="/csomagok/<?= $params['package']["slug"] ?>?res=1?href=#resForm">
                    <button class="btn btn-sm btn-success float-end">Lefoglalom</button>
                </a>
            <?php endif; ?>
    </div>
</div>