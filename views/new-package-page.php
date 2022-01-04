<div class="card p-3 m-5">
    <div class="card border-success mb-3">
        <div class="card-header">Új szállás</div>
            <div class="card-body">
                <form class="form-inline" action="/add-package" method="POST" id="newPck">
                    <div class="form-group">
                        <div class="container">
                            <h5>Alapadatok</h5>
                            <div class="row">
                                <div style="max-width: 15rem;">
                                    <label for="name" class="form-label mt-4">Szállás neve</label>
                                    <input class="form-control" type="text" name="name" autocomplete="off"/>                                        
                                </div>                
                                <div style="max-width: 15rem;">
                                    <label for="location" class="form-label mt-4">Település</label>
                                    <input class="form-control" type="text" name="location" autocomplete="off"/>                                        
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            <h5>Szálláshely típusa</h5>
                            <br>
                                <div class="row">
                                <?php foreach($params['accmTypes'] as $accmType) : ?>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="type">
                                        <input class="form-check-input" type="radio"  name="type" value="<?= $accmType['type_code']?>">
                                            <?= $accmType['name']?>
                                        </label>
                                    </div>                                    
                                <?php endforeach; ?>
                            </div>                                       
                        </div>
                        <hr>
                        <div class="container">
                            <h5>Árak</h5>
                            <div class="row">
                                <label for="price" class="col-sm-1 col-form-label">Szállás</label>
                                <div class="col-sm-1">
                                    <input class="form-control" type="text" name="price" autocomplete="off"/>
                                </div>
                                <label for="price" class="col-sm-2 col-form-label">RON/fő/éj</label>                                
                            </div>
                            <div class="row">
                                <label for="breakfastPrice" class="col-sm-1 col-form-label">Reggeli</label>
                                <div class="col-sm-1">
                                    <input class="form-control" type="text" name="breakfastPrice" autocomplete="off"/>
                                </div>
                                <label for="breakfastPrice" class="col-sm-2 col-form-label">RON/fő/alkalom</label>                                
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            <h5>Felszereltség</h5>
                            <br>
                                <div class="row">
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="MEA">
                                            Étkezés
                                        </label>
                                    </div>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="INT">
                                            Internet
                                        </label>
                                    </div>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="PRK">
                                            Parkoló
                                        </label>
                                    </div>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="AIR">
                                            Légkondi
                                        </label>
                                    </div>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="HEA">
                                            Fűtés
                                        </label>
                                    </div>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="WEL">
                                            Wellness
                                        </label>
                                    </div>
                                    <div class="form-check" style="max-width: 8rem;">
                                        <label class="form-check-label" for="services">
                                        <input class="form-check-input" type="checkbox"  name="services" value="POL">
                                            Medence
                                        </label>
                                    </div>                      
                                </div>                                       
                        </div>
                        <hr>
                        <div class="container">
                            <label for="description" class="form-label mt-4">Leírás</label>
                            <textarea class="form-control" id="description" name="description" form="pckUpdate" rows="3"></textarea>
                        </div>
                        <br>
                        <br>
                        <div class="btn-group float-end">
                            <a href="/csomagok">
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2">Vissza</button>
                            </a>
                            <button type="submit" class="btn btn-sm btn-success">Létrehoz</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>