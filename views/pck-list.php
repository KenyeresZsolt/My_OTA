<?php if($params['info'] === "added"): ?>
    <div class="alert alert-success">
        Csomag létrehozva!
    </div>
<?php elseif($params['info'] === "deleted"): ?>
    <div class="alert alert-danger">
        Csomag sikeresen törölve!
    </div>
<?php endif ?>
<?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
    <div class="container">
        <a href="/uj-csomag">
            <button class="btn btn-sm btn-primary float-end">Új csomag</button>
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
            <form action="/csomagok" method="POST">
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
                    <input class="form-control-sm" style="max-width: 3.5rem" type="text" name="minPrice" placeholder="min" value="<?= $params['minPriceFilter']?>" autocomplete="off">
                    -
                    <input class="form-control-sm" style="max-width: 3.5rem" type="text" name="maxPrice" placeholder="max" value="<?= $params['maxPriceFilter']?>" autocomplete="off">
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
                    <a href="/csomagok">
                        <button type="button" class="btn btn-sm btn-outline-primary mr-2">Törlés</button>
                    </a>
                    <button type="submit" class="btn btn-sm btn-success">Szűrés</button>
                </div>
            </form>
        </div>
    </div>
</div> 
<div class="row col-md-10">
    <p><?= count($params['packages']) . " találat"?></p>
    <?php foreach($params['packages'] as $package): ?>
        <div class="card border-success mb-5 me-auto col-auto" id="<?php echo $package['id']?>" style="width:20rem">
            <div class="card-header container-fluid h4">
                <?php echo $package['name'] . " " . $package['location'];?>
            </div>
            <div class="card-body container-fluid">
                <div class="align-middle">    
                    <?php if(isset($package['image'])): ?>
                        <img class="img-fluid img-thumbnail" src="<?php echo $package['image']?>" alt="<?php echo $package['name'] ?>" style="width:318px">
                    <?php endif; ?>
                </div>
                <br>
                <br>
                <a href="/csomagok/<?php echo $package["slug"] ?>" target="_blank">
                    <button class="btn btn-sm btn-outline-success float-end">Részletek</button>
                </a>
                <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                    <form action="/delete-package/<?php echo $package['id'] ?>" method="post">
                        <button type="submit" class="btn btn-sm btn-danger float-end">Törlés</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</div>
<?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
    <hr>
    <div class="container">
        <a href="/uj-csomag">
            <button class="btn btn-sm btn-primary float-end">Új csomag</button>
        </a>
    </div>
<?php endif; ?>
