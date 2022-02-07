<?php if($params['info'] === "added"): ?>
    <a href="/szallasok" style="text-decoration:none">
        <div class="alert alert-success text-center">
            Szállás létrehozva!
        </div>
    </a>
<?php elseif($params['info'] === "deleted"): ?>
    <a href="/szallasok" style="text-decoration:none">
        <div class="alert alert-danger text-center">
            Szállás sikeresen törölve!
        </div>
    </a>
<?php endif ?>
<?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
    <div class="container">
        <a href="/uj-szallas">
            <button class="btn btn-sm btn-outline-success float-end">Új szállás</button>
        </a>
    </div>
<?php endif; ?>
<hr>
<div class="row">
<div class="col-md-2">
    <div class="card border-primary" id="filters" style="width:10rem">
        <div class="card-header container-fluid h4">
            Szűrők
        </div>
        <div class="card-body container-fluid">
            <form action="/filter-accms" method="POST">
                <p>Típus</p>
                <?php foreach($params['accmTypes'] as $accmType) : ?>
                    <div class="form-check">
                        <label class="form-check-label" for="type">
                        <input class="form-check-input" type="checkbox"  name="type[]" value="<?= $accmType['type_code']?>" <?= strpos(" " /*meghekkelt megoldás :) */ . $params['typeFilter'], $accmType['type_code']) ? "checked" : "" ?>>
                            <?= $accmType['name']?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div>
                    <label for="price" class="form-label">Ár</label><br>
                    <div class="row">
                        <input class="form-control" style="max-width: 4rem" type="text" name="minPrice" placeholder="min" value="<?= $params['minPriceFilter']?>" autocomplete="off">
                         - 
                        <input class="form-control" style="max-width: 4rem" type="text" name="maxPrice" placeholder="max" value="<?= $params['maxPriceFilter']?>" autocomplete="off">
                    </div>
                </div>
                <hr>
                <p>Szolgáltatások</p>
                <?php foreach($params['accmFacilities'] as $accmFacility) : ?>
                    <div class="form-check">
                        <label class="form-check-label" for="facility">
                        <input class="form-check-input" type="checkbox"  name="facility[]" value="<?= $accmFacility['facility_code']?>" <?= strpos(" " /*meghekkelt megoldás :) */ . $params['facilityFilter'], $accmFacility['facility_code']) ? "checked" : "" ?>>
                            <?= $accmFacility['name']?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <hr>
                <p>Beszélt nyelvek</p>
                <?php foreach($params['accmLangs'] as $accmLang) : ?>
                    <div class="form-check">
                        <label class="form-check-label" for="lang">
                        <input class="form-check-input" type="checkbox"  name="lang[]" value="<?= $accmLang['code']?>" <?= strpos(" " /*meghekkelt megoldás :) */ . $params['langFilter'], $accmLang['code']) ? "checked" : "" ?>>
                            <?= $accmLang['name']?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="btn-group float-end">
                    <a href="/szallasok">
                        <button type="button" class="btn btn-sm btn-outline-secondary mr-2">Törlés</button>
                    </a>
                    <button type="submit" class="btn btn-sm btn-success">Szűrés</button>
                </div>
        </div>
    </div>
</div> 
<div class="col-md-10">
    <div class="card border-primary mb-5" style="max-height:6rem">
        <div class="card-body d-inline-flex">
            <div class="me-sm-2" style="width: 25rem;">
                <label for="destination">Úti cél</label>
                <input class="form-control me-sm-2" type="text" list="destination" name="destination" value="<?= $params['destFilter']?>" autocomplete="off">
                    <datalist id="destination">
                        <?php foreach($params['accms'] as $accm):?>
                            <option value="<?= $accm['name'] ?>">
                        <?php endforeach; ?>
                    </datalist>
            </div>
            <div class="me-sm-2" style="max-width: 11rem;">
                <label for="checkin">Érkezés</label>
                <input class="form-control" type="date" name="checkin" min="<?= date("Y-m-d"); ?>" value="<?= $params['checkinFilter']?>" autocomplete="off"/>
            </div>
            <div class="me-sm-2" style="max-width: 11rem;">
                <label for="checkout">Távozás</label>
                <input class="form-control" type="date" name="checkout" min="<?= date("Y-m-d"); ?>" value="<?= $params['checkoutFilter']?>" autocomplete="off"/>
            </div>
            <div class="me-sm-2" style="max-width: 6rem;">
                <label for="guests">Felnőttek</label>
                <input class="form-control" type="number" name="adults" min="1" value="<?= !is_null($params['adultsFilter']) ? $params['adultsFilter'] : '1' ?>" autocomplete="off"/>
            </div>
            <div class="me-sm-2" style="max-width: 6rem;">
                <label for="guests">Gyerekek</label>
                <input class="form-control" type="number" name="children" min="0" value="<?= !is_null($params['childrenFilter']) ? $params['childrenFilter'] : '0' ?>" autocomplete="off"/>
            </div>
            <button class="btn btn-success mt-auto" type="submit">Keresés</button>
        </div>
    </div>
    <div class="row">
        <p class="col-md-9 style="max-height:1rem"><?= count($params['accms']) . " találat"?></p>
        <div class=" col-md-3">
            <select name="sort" class="form-control-sm" style="max-width:9rem;">
                <option value="default">Alapértelmezett</option>
                <option value="asc"> Ár szerint növekvő</option>
                <option value="desc"> Ár szerint csökkenő</option>
            </select>
            <button class="btn btn-sm btn-success" type="submit">Rendezés</button>
        </div>
    </div>
    </form>   
    <br>
    <?php foreach($params['accms'] as $accm): ?>
        <div class="card border-success mb-5" style="height:18rem" id="<?php echo $accm['id']?>">
            <div class="card-header h4">
                <?php echo $accm['name'] . " " . $accm['location'];?>
            </div>
            <div class="row card-body container-fluid">
                <div class="col-md-4">
                    <img class="img-fluid img-thumbnail" src="
                    <?php foreach($params['images'] as $image){
                        if($image['accm_id'] === $accm['id']){
                            echo $image['path'];
                        }
                        }
                    ?>" 
                    alt="<?php echo $accm['name'] ?>" style="width:350px">
                </div>
                <div class="col-md-8">
                    <div class="row align-middle ms-3 mb-4" style="height:65%">
                        <ul class="mt-4 col-md-9">
                            <li><?= $accm['capacity'] . " férőhely" ?></li>
                            <li><?= $accm['rooms'] . " szoba" ?></li>
                            <li><?= $accm['bathrooms'] . " fürdőszoba" ?></li>
                        </ul>
                        <div class="col-md-3">
                            <span class="fw-bold float-end"><?= $accm['best_price'] . " RON" ?></span><br>
                            <span class="small float-end"><?= $params['userInput']['nights'] . " éj, " . $params['userInput']['guests'] . " főnek "?></span>
                        </div>
                    </div>
                    <div class="btn-group float-end">
                        <a href="/szallasok/<?php echo $accm["slug"] ?>">
                            <button class="btn btn-sm btn-outline-success float-end">Részletek</button>
                        </a>
                        <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                            <form action="/delete-accm/<?php echo $accm['id'] ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-danger float-end">Törlés</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</div>
<?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
    <hr>
    <div class="container">
        <a href="/uj-szallas">
            <button class="btn btn-sm btn-outline-success float-end">Új szállás</button>
        </a>
    </div>
<?php endif; ?>
