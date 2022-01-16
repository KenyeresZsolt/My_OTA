<?php if($params['info'] === "updated"): ?>
    <a href="/szallasok/<?= $params['accm']['slug'] ?>/beallitasok/szobak/szoba-szerkesztese/<?= $params['unit']['id']?>" style="text-decoration:none">
        <div class="alert alert-success text-center mb-3 m-5">
            Szoba frissítve!
        </div>
    </a>
<?php endif; ?>
<?php if($params['unit']['unit_type'] === "room"):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Szoba szerkesztése</div>
        <div class="card-body">
            <form class="form-inline" action="/update-unit/<?= $params['unit']['id'] ?>" method="POST" id="newRoom">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div style="max-width: 35rem;">
                                <label for="name" class="form-label mt-4">Szoba megnevezése (így jelenik meg az adatlapon)</label>
                                <input class="form-control form-control-sm" type="text" name="name" value="<?= $params['unit']['name'] ?>" autocomplete="off"/>                                        
                            </div>                
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Ágyak típusa</p>
                            <?php foreach($params['bedTypes'] as $bedType):?>
                            <div class="row mt-4">
                                <label for="bedTypes" class="col-form-label" style="max-width:16rem;"><?= $bedType['name'] . " (" . $bedType['places'] . " fő)"  ?></label>
                                <input class="form-control form-control-sm" style="max-width:3rem;" type="number" name="bedTypes[<?=$bedType['value']?>]" value="<?= $params['unitBedTypes'][$bedType['value']]?>" autocomplete="off"/>                                        
                                <label for="bedTypes" class="col-form-label" style="max-width:3rem;">db</label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Fürdőszoba</p>
                        <div class="row">
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="OWN" <?= $params['unit']['bathroom_type'] === "OWN" ? "checked" : "" ?>>
                                    Saját
                                </label>
                            </div>
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="COMMON" <?= $params['unit']['bathroom_type'] === "COMMON" ? "checked" : "" ?>>
                                    Közös
                                </label>
                            </div>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Szoba ára</p>
                        <div class="row">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="text" name="price" value="<?= $params['unit']['price'] ?>" autocomplete="off"/>                                        
                            <label for="price" class="col-form-label" style="max-width:5rem;">RON</label>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Darabszám</p>
                        <div class="row">
                            <label for="count" class="col-form-label" style="max-width:25rem;">Hány darab ilyen felszereltségű szobád van?</label>
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="count" value="<?= $params['unit']['count'] ?>" autocomplete="off"/>                                        
                        </div>
                    </div>
                </div>
                <hr style="border: 1px dashed white">
                <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
            </form>
        </div>
    </div>
<?php elseif($params['unit']['unit_type'] === "apartment"):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Apartman szerkesztése</div>
        <div class="card-body">
            <form class="form-inline" action="/update-unit/<?= $params['unit']['id'] ?>" method="POST" id="newApt">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div style="max-width: 35rem;">
                                <label for="name" class="form-label mt-4">Apartman megnevezése (így jelenik majd meg az adatlapon)</label>
                                <input class="form-control form-control-sm" type="text" name="name" value="<?= $params['unit']['name'] ?>" autocomplete="off"/>                                        
                            </div>                
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Szobák száma</p>
                            <div class="row">
                                <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="roomsCount" value="<?= $params['unit']['rooms_count'] ?>" autocomplete="off"/>                                        
                                <label for="roomsCount" class="col-form-label" style="max-width:5rem;">darab</label>
                            </div>
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Ágyak típusa</p>
                            <?php foreach($params['bedTypes'] as $bedType):?>
                            <div class="row mt-4">
                                <label for="bedTypes" class="col-form-label" style="max-width:16rem;"><?= $bedType['name'] . " (" . $bedType['places'] . " fő)"  ?></label>
                                <input class="form-control form-control-sm" style="max-width:3rem;" type="number" name="bedTypes[<?=$bedType['value']?>]" value="<?= $params['unitBedTypes'][$bedType['value']]?>" autocomplete="off"/>                                        
                                <label for="bedTypes" class="col-form-label" style="max-width:3rem;">db</label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Fürdőszoba</p>
                        <div class="row">
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="OWN" <?= $params['unit']['bathroom_type'] === "OWN" ? "checked" : "" ?>>
                                    Saját
                                </label>
                            </div>
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="COMMON" <?= $params['unit']['bathroom_type'] === "COMMON" ? "checked" : "" ?>>
                                    Közös
                                </label>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="bathroomsCount" value="<?= $params['unit']['bathrooms_count'] ?>" autocomplete="off"/>                                        
                            <label for="bathroomsCount" class="col-form-label" style="max-width:5rem;">darab</label>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Apartman ára</p>
                        <div class="row">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="text" name="price" value="<?= $params['unit']['price'] ?>" autocomplete="off"/>                                        
                            <label for="price" class="col-form-label" style="max-width:5rem;">RON</label>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Darabszám</p>
                        <div class="row">
                            <label for="count" class="col-form-label" style="max-width:25rem;">Hány darab ilyen felszereltségű apartmanod van?</label>
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="count" value="<?= $params['unit']['count'] ?>" autocomplete="off"/>                                        
                        </div>
                    </div>
                </div>
                <hr style="border: 1px dashed white">
                <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
            </form>
        </div>
    </div>
<?php elseif($params['unit']['unit_type'] === "complete"):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Teljes szálláshely foglalhatóságának beállítása</div>
        <div class="card-body">
            <form class="form-inline" action="/update-unit/<?= $params['unit']['id'] ?>" method="POST" id="complete">
                <div class="form-group">
                    <div class="container">
                    <div class="row">
                            <div style="max-width: 10rem;">
                                <label for="rooms" class="form-label mt-4">Szobák száma</label>
                                <input class="form-control form-control-sm" type="text" name="roomsCount" value="<?= $params['unit']['rooms_count'] ?>" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 11rem;">
                                <label for="bathrooms" class="form-label mt-4">Fördőszobák száma</label>
                                <input class="form-control form-control-sm" type="text" name="bathroomsCount" value="<?= $params['unit']['bathrooms_count'] ?>" autocomplete="off"/>                                        
                            </div>
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Ágyak típusa</p>
                            <?php foreach($params['bedTypes'] as $bedType):?>
                            <div class="row mt-4">
                                <label for="bedTypes" class="col-form-label" style="max-width:16rem;"><?= $bedType['name'] . " (" . $bedType['places'] . " fő)"  ?></label>
                                <input class="form-control form-control-sm" style="max-width:3rem;" type="number" name="bedTypes[<?=$bedType['value']?>]" value="<?= $params['unitBedTypes'][$bedType['value']]?>" autocomplete="off"/>                                        
                                <label for="bedTypes" class="col-form-label" style="max-width:3rem;">db</label>
                            </div>
                            <?php endforeach; ?>
                            </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Teljes ár</p>
                        <div class="row">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="text" name="price" value="<?= $params['unit']['price']?>" autocomplete="off"/>                                        
                            <label for="price" class="col-form-label" style="max-width:5rem;">RON</label>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px dashed white">
                <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
            </form>
        </div>
    </div>
<?php endif; ?> 