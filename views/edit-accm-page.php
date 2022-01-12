<?php if($params['info'] === "updated"): ?>
    <a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/adatok" style="text-decoration:none">
        <div class="alert alert-success text-center mb-3 m-5">
            Szállás frissítve!
        </div>
    </a>
<?php endif; ?>
<div class="card border-success mb-3 m-5">
    <div class="card-header">Szállás szerkesztése</div>
        <div class="card-body">
            <form class="form-inline" action="/update-accm/<?= $params['accm']['id']?>" method="POST" enctype="multipart/form-data" id="updtAccm">
                <div class="form-group">
                    <div class="container">
                        <h5>Alapadatok</h5>
                        <div class="row">
                            <div style="max-width: 35rem;">
                                <label for="name" class="form-label mt-4">Szállás neve</label>
                                <input class="form-control form-control-sm" type="text" name="name" value="<?= $params['accm']['name']?>" autocomplete="off"/>                                        
                            </div>                
                        </div>
                        <div class="row">
                            <p class="mt-4">Szálláshely típusa</p>
                            <?php foreach($params['accmTypes'] as $accmType) : ?>
                                <div class="form-check" style="max-width: 8rem;">
                                    <label class="form-check-label" for="type">
                                    <input class="form-check-input" type="radio"  name="type" value="<?= $accmType['type_code']?>" <?= $accmType['type_code'] === $params['accm']["accm_type"] ? "checked" : "" ?>>
                                        <?= $accmType['name']?>
                                    </label>
                                </div>                                    
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div style="max-width: 10rem;">
                                <label for="capacity" class="form-label mt-4">Férőhelyek száma</label>
                                <input class="form-control form-control-sm" type="text" name="capacity" value="<?= $params['accm']['capacity']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 10rem;">
                                <label for="rooms" class="form-label mt-4">Szobák száma</label>
                                <input class="form-control form-control-sm" type="text" name="rooms" value="<?= $params['accm']['rooms']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 11rem;">
                                <label for="bathrooms" class="form-label mt-4">Fürdőszobák száma</label>
                                <input class="form-control form-control-sm" type="text" name="bathrooms" value="<?= $params['accm']['bathrooms']?>" autocomplete="off"/>                                        
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <p>Beszélt nyelvek</p>
                            <?php foreach($params['accmLangs'] as $accmLang) : ?>
                                <div class="form-check" style="max-width: 8rem;">
                                    <label class="form-check-label" for="languages">
                                    <input class="form-check-input" type="checkbox"  name="languages[]" value="<?= $accmLang['code']?>" <?= !is_array($params['languages']) ? "" : in_array($accmLang['code'], $params['languages']) ? "checked" : "" ?>>
                                        <?= $accmLang['name']?>
                                    </label>
                                </div>                                    
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <br><hr><br>
                    <div class="container">
                        <h5>Képek a szállásról</h5>
                        <br>
                        <div class="row">
                            <input class="form-control" style="max-width:25rem;" type="file" name="fileToUpload" id="fileToUpload">
                        </div>                   
                    </div>
                    <br><hr><br>
                    <div class="container">
                        <h5>Árak</h5>
                        <div class="row">
                            <label for="price" class="col-sm-1 col-form-label">Szállás</label>
                            <div class="col-sm-1">
                                <input class="form-control form-control-sm" type="text" name="price" value="<?= $params['accm']['price']?>" autocomplete="off"/>
                            </div>
                            <label for="price" class="col-sm-2 col-form-label">RON/fő/éj</label>                                
                        </div>
                    </div>
                    <br><hr><br>
                    <div class="container">
                        <h5>Felszereltség</h5>
                        <br>
                        <div class="row">
                            <?php foreach($params['accmFacilities'] as $accmFacility) : ?>
                                <div class="form-check" style="max-width: 8rem;">
                                    <label class="form-check-label" for="facilities">
                                    <input class="form-check-input" type="checkbox"  name="facilities[]" value="<?= $accmFacility['facility_code']?>" <?= !is_array($params['facilities']) ? "" :  in_array($accmFacility['facility_code'], $params['facilities']) ? "checked" : "" ?>>
                                        <?= $accmFacility['name']?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <br><hr><br>
                    <h5>Szálláshely bemutatása</h5>
                    <div class="container">
                        <label for="description" class="form-label mt-4">Leírás</label>
                        <textarea class="form-control form-control-sm" id="description" name="description" form="updtAccm" rows="10"><?= $params['accm']['description']?></textarea>
                    </div>
                    <br>
                    <br><hr><br>
                    <div class="container">
                        <h5>Szállás címe</h5>
                        <div class="row">
                            <div style="max-width: 35rem;">
                                <label for="location" class="form-label mt-4">Település</label>
                                <input class="form-control form-control-sm" type="text" name="location" value="<?= $params['accm']['location']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="postalCode" class="form-label mt-4">Irányítószám</label>
                                <input class="form-control form-control-sm" type="text" name="postalCode" value="<?= !is_array($params['address']) ? "" : $params['address']['postalCode']?>" autocomplete="off"/>                                        
                            </div>
                        </div>
                        <div class="row">
                            <div style="max-width: 25rem;">
                                <label for="street" class="form-label mt-4">Utca</label>
                                <input class="form-control form-control-sm" type="text" name="street" value="<?= !is_array($params['address']) ? "" : $params['address']['street']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 8rem;">
                                <label for="number" class="form-label mt-4">Házszám</label>
                                <input class="form-control form-control-sm" type="text" name="number" value="<?= !is_array($params['address']) ? "" : $params['address']['number']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 8rem;">
                                <label for="building" class="form-label mt-4">Épület</label>
                                <input class="form-control form-control-sm" type="text" name="building" value="<?= !is_array($params['address']) ? "" : $params['address']['building']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 8rem;">
                                <label for="floor" class="form-label mt-4">Emelet</label>
                                <input class="form-control form-control-sm" type="text" name="floor" value="<?= !is_array($params['address']) ? "" : $params['address']['floor']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 8rem;">
                                <label for="door" class="form-label mt-4">Ajtó</label>
                                <input class="form-control form-control-sm" type="text" name="door" value="<?= !is_array($params['address']) ? "" : $params['address']['door']?>" autocomplete="off"/>                                        
                            </div>
                        </div>
                    </div>
                    <br><hr><br>
                    <div class="container">
                        <h5>Kapcsolati adatok</h5>
                        <div class="row">
                            <div style="max-width: 15rem;">
                                <label for="contactName" class="form-label mt-4">Kapcsolattartó neve</label>
                                <input class="form-control form-control-sm" type="text" name="contactName" value="<?= $params['accm']['contact_name']?>"autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="contactEmail" class="form-label mt-4">Szállás emailcíme</label>
                                <input class="form-control form-control-sm" type="text" name="contactEmail" value="<?= $params['accm']['email']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="contactPhone" class="form-label mt-4">Szállás telefonszáma</label>
                                <input class="form-control form-control-sm" type="text" name="contactPhone" value="<?= $params['accm']['phone']?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="webpage" class="form-label mt-4">Szállás honlapja</label>
                                <input class="form-control form-control-sm" type="text" name="webpage" value="<?= $params['accm']['webpage']?>" autocomplete="off"/>                                        
                            </div>
                        </div>
                    </div>
                    <br><hr><br>
                        <button type="submit" class="btn btn-sm btn-success">Lementem</button>
                </div>
            </form>
        </div>
</div>
