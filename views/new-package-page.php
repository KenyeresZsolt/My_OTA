<div class="card p-3 m-5">
    <div class="row">
        <div class="card p-3 border-success ms-auto me-auto" style="max-width: 25rem;">
            <form action="/add-package" method="POST" id="newPck">
                <h2 class="text-center">Új csomag létrehozása</h2>
                <br>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="name" id="name" autocomplete="off">
                    <label for="name">Név</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="location" id="location" autocomplete="off">
                    <label for="location">Település</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-control" name="type">
                        <option value="none" selected disabled hidden></option>
                        <?php foreach($params['accmTypes'] as $accmType) : ?>
                            <option value="<?= $accmType['typeCode']?>"><?= $accmType['name']?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="type">Típus</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="price" id="price" autocomplete="off">
                    <label for="price">Ár</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="discount" id="discount" autocomplete="off">
                    <label for="discount">Kedvezmény</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" type="text" name="description" id="description" autocomplete="off" form="newPck" rows="5"></textarea>
                    <label for="description">Leírás</label>
                </div>
                <br>
                <button type="submit" class="btn btn-sm btn-primary mr-2 float-end">Létrehozás</button>
                <a href="/csomagok">
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2 float-end">Mégse</button>
                </a>
            </form>
        </div>
    </div>
</div>