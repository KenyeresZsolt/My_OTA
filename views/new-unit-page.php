<?php if($params['type'] === NULL):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Válaszd ki a feltölteni kívánt egység típusát!</div>
        <div class="card-body">
            <form class="container row" action="/szallasok/<?= $params['accm']['slug'] ?>/beallitasok/szobak/uj-szoba" method="GET">
                <select name="type" class="form-control-sm col-md-4" style="max-width:10rem;">
                    <option value="none" selected disabled hidden>Kiválaszt</option>
                    <option value="room" <?= $params['type'] === "room" ? "selectet" : "" ?>> Szoba</option>
                    <option value="apartment" <?= $params['type'] === "apartment" ? "selectet" : "" ?>> Apartman</option>
                    <option value="complete" <?= $params['type'] === "complete" ? "selectet" : "" ?>> Teljes <?= $params['accm']['type'] ?></option>
                </select>
                <button type="submit" class="btn btn-sm btn-success col-sm-1">OK</button>
            </form>
        </div>
    </div>
<?php elseif($params['type'] === "room"):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Új szoba</div>
        <div class="card-body">
            <form class="form-inline" action="/add-unit/<?= $params['accm']['id'] ?>?type=room" method="POST" id="newRoom">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div style="max-width: 35rem;">
                                <label for="name" class="form-label mt-4">Szoba megnevezése (így jelenik majd meg az adatlapon)</label>
                                <input class="form-control form-control-sm" type="text" name="name" autocomplete="off"/>                                        
                            </div>                
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Ágyak típusa</p>
                            <?php foreach($params['bedTypes'] as $bedType):?>
                            <div class="row mt-4">
                                <label for="bedTypes" class="col-form-label" style="max-width:16rem;"><?= $bedType['name'] . " (" . $bedType['places'] . " fő)"  ?></label>
                                <input class="form-control form-control-sm" style="max-width:3rem;" type="number" name="bedTypes[<?=$bedType['value']?>]" value="0" autocomplete="off"/>                                        
                                <label for="bedTypes" class="col-form-label" style="max-width:3rem;">db</label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Fürdőszoba</p>
                        <div class="row">
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="OWN">
                                    Saját
                                </label>
                            </div>
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="COMMON">
                                    Közös
                                </label>
                            </div>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Szoba ára</p>
                        <div class="row">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="text" name="price" autocomplete="off"/>                                        
                            <label for="price" class="col-form-label" style="max-width:5rem;">RON</label>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Darabszám</p>
                        <div class="row">
                            <label for="count" class="col-form-label" style="max-width:25rem;">Hány darab ilyen felszereltségű szobád van?</label>
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="count" autocomplete="off"/>                                        
                        </div>
                    </div>
                </div>
                <hr style="border: 1px dashed white">
                <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
            </form>
        </div>
    </div>
<?php elseif($params['type'] === "apartment"):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Új apartman</div>
        <div class="card-body">
            <form class="form-inline" action="/add-unit/<?= $params['accm']['id'] ?>?type=apartment" method="POST" id="newApt">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div style="max-width: 35rem;">
                                <label for="name" class="form-label mt-4">Apartman megnevezése (így jelenik majd meg az adatlapon)</label>
                                <input class="form-control form-control-sm" type="text" name="name" autocomplete="off"/>                                        
                            </div>                
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Szobák száma</p>
                            <div class="row">
                                <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="roomsCount" autocomplete="off"/>                                        
                                <label for="roomsCount" class="col-form-label" style="max-width:5rem;">darab</label>
                            </div>
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Ágyak típusa</p>
                            <?php foreach($params['bedTypes'] as $bedType):?>
                            <div class="row mt-4">
                                <label for="bedTypes" class="col-form-label" style="max-width:16rem;"><?= $bedType['name'] . " (" . $bedType['places'] . " fő)"  ?></label>
                                <input class="form-control form-control-sm" style="max-width:3rem;" type="number" name="bedTypes[<?=$bedType['value']?>]" value="0" autocomplete="off"/>                                        
                                <label for="bedTypes" class="col-form-label" style="max-width:3rem;">db</label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Fürdőszoba</p>
                        <div class="row">
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="OWN">
                                    Saját
                                </label>
                            </div>
                            <div class="form-check" style="max-width: 8rem;">
                                <label class="form-check-label" for="bathroomType">
                                <input class="form-check-input" type="radio"  name="bathroomType" value="COMMON">
                                    Közös
                                </label>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="bathroomsCount" autocomplete="off"/>                                        
                            <label for="bathroomsCount" class="col-form-label" style="max-width:5rem;">darab</label>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Apartman ára</p>
                        <div class="row">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="text" name="price" autocomplete="off"/>                                        
                            <label for="price" class="col-form-label" style="max-width:5rem;">RON</label>
                        </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Darabszám</p>
                        <div class="row">
                            <label for="count" class="col-form-label" style="max-width:25rem;">Hány darab ilyen felszereltségű apartmanod van?</label>
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="number" name="count" autocomplete="off"/>                                        
                        </div>
                    </div>
                </div>
                <hr style="border: 1px dashed white">
                <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
            </form>
        </div>
    </div>
<?php elseif($params['type'] === "complete"):?>
    <div class="card border-success mb-3 m-5">
        <div class="card-header">Teljes szálláshely foglalhatóságának beállítása</div>
        <div class="card-body">
            <form class="form-inline" action="/add-unit/<?= $params['accm']['id'] ?>?type=complete" method="POST" id="complete">
                <div class="form-group">
                    <div class="container">
                    <div class="row">
                            <div style="max-width: 10rem;">
                                <label for="rooms" class="form-label mt-4">Szobák száma</label>
                                <input class="form-control form-control-sm" type="text" name="roomsCount" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 11rem;">
                                <label for="bathrooms" class="form-label mt-4">Fördőszobák száma</label>
                                <input class="form-control form-control-sm" type="text" name="bathroomsCount" autocomplete="off"/>                                        
                            </div>
                        </div>
                        <hr style="border: 1px dashed white">
                        <div>
                            <p class="mt-4 h4">Ágyak típusa</p>
                            <?php foreach($params['bedTypes'] as $bedType):?>
                            <div class="row mt-4">
                                <label for="bedTypes" class="col-form-label" style="max-width:16rem;"><?= $bedType['name'] . " (" . $bedType['places'] . " fő)"  ?></label>
                                <input class="form-control form-control-sm" style="max-width:3rem;" type="number" name="bedTypes[<?=$bedType['value']?>]" value="0" autocomplete="off"/>                                        
                                <label for="bedTypes" class="col-form-label" style="max-width:3rem;">db</label>
                            </div>
                            <?php endforeach; ?>
                            </div>
                        <hr style="border: 1px dashed white">
                        <p class="mt-4 h4">Teljes ár</p>
                        <div class="row">
                            <input class="form-control form-control-sm" style="max-width:5rem;" type="text" name="price" autocomplete="off"/>                                        
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