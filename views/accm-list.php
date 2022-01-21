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
            </form>
        </div>
    </div>
</div> 
<div class="row col-md-10">
    <p style="max-height:1rem"><?= count($params['accms']) . " találat"?></p>
    <?php foreach($params['accms'] as $accm): ?>
        <div class="card border-success mb-5 me-auto" id="<?php echo $accm['id']?>" style="width:20rem">
            <div class="card-header h4">
                <?php echo $accm['name'] . " " . $accm['location'];?>
            </div>
            <div class="card-body container-fluid">
                <div class="align-middle">
                    <img class="img-fluid img-thumbnail" src="
                    <?php foreach($params['images'] as $image){
                        if($image['accm_id'] === $accm['id']){
                            echo $image['path'];
                        }
                        }
                    ?>" 
                    alt="<?php echo $accm['name'] ?>" style="width:318px">
                </div>
                <br>
                <br>
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
