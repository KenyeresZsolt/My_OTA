<div class="card p-3 m-5">
    <div class="card border-success mb-3">
        <div class="card-header">Új szállás</div>
            <div class="card-body">
                <form class="form-inline" action="/add-package" method="POST" id="newPck">
                    <div class="form-group">
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
                        <div class="row container">
                            <label for="type" class="form-label mt-4">Szálláshely típusa</label>
                                <?php foreach($params['accmTypes'] as $accmType) : ?>
                                    <div class="form-check">
                                        <label class="form-check-label" for="type">
                                        <input class="form-check-input" type="radio"  name="type" value="<?= $accmType['type_code']?>">
                                            <?= $accmType['name']?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>                                          
                        </div>
                        <div class="row">
                            <div style="max-width: 15rem;">
                                <label for="price" class="form-label mt-4">Ár (/fő/éj)</label>
                                <input class="form-control" type="text" name="price" autocomplete="off"/>                                        
                            </div>
                            <div style="max-width: 15rem;">
                                <label for="breakfast" class="form-label mt-4">Reggeli ára (/fő/alkalom)</label>
                                <input class="form-control" type="text" name="breakfast" autocomplete="off"/>                                        
                            </div>
                        </div>
                        <div class="row">
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