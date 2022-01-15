<?php if($params['info'] === "mealsUpdated"): ?>
    <a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szolgaltatasok?#editMealsForm" style="text-decoration:none">
        <div class="alert alert-success text-center mb-3 m-5" id="editMealsMessage">
            Étkezések frissítve!
        </div>
    </a>
<?php elseif($params['info'] === "mealsEmptyPrice"): ?>
<a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szolgaltatasok?#editMealsForm" style="text-decoration:none">
    <div class="alert alert-danger text-center mb-3 m-5" id="editMealsMessage">
        Add meg az árat fizetős étkezés esetén!
    </div>
</a>
<?php elseif($params['info'] === "mealsNotSpecified"): ?>
<a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szolgaltatasok?#editMealsForm" style="text-decoration:none">
    <div class="alert alert-danger text-center mb-3 m-5" id="editMealsMessage">
        Add meg a biztosított étkezéseket!
    </div>
</a>
<?php endif; ?>
<div class="card border-success mb-3 m-5" id="editMealsForm">
    <div class="card-header">Étkezés</div>
    <div class="card-body">
        <form class="form-inline" action="/update-meals/<?= $params['accm']['id'] ?>" method="POST">
            <div class="container row">            
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="mealOffered">
                    <input class="form-check-input" type="radio"  name="mealOffered" value="YES" <?= $params['accm']['meal_offered'] === "YES" ? "checked" : "" ?>>
                        Biztosítok étkezést
                    </label>
                </div>
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="mealOffered">
                    <input class="form-check-input" type="radio"  name="mealOffered" value="NO" <?= $params['accm']['meal_offered'] !== "YES" ? "checked" : "" ?>>
                        Nem biztosítok étkezést 
                    </label>
                </div>
            </div>
            <hr style="border: 1px dashed white">
            <table>
                <tr>
                    <?php foreach($params['meals'] as $meal): ?>
                        <td>
                            <div class="container">
                                <p class="mt-4 fw-bold"><?= $meal['name'] ?></p>
                                <div class="container">
                                    <?php foreach($params['mealsStatus'] as $mealStatus): ?>
                                    <div class="row">          
                                        <div class="form-check" style="max-width: 15rem;">
                                            <label class="form-check-label" for="<?= $meal['value'] ?>">
                                            <input class="form-check-input" type="radio"  name="<?= $meal['value'] ?>" value="<?= $mealStatus['value'] ?>" <?= (($mealStatus['value'] === @$params['accm'][$meal['value']]) OR ($params['accm']['meal_offered'] !== "YES" AND $mealStatus['value'] === "NOTPROVIDED"))  ? "checked" : "" ?>>
                                                <?= $mealStatus['name'] ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input class="form-control form-control-sm" type="text" name="<?= $meal['value'] ?>Price" value="<?= @$params['accm'][$meal['value'] . "_price"] ?>" autocomplete="off"/>
                                        </div>
                                        <label for="<?= $meal['value'] ?>Price" class="col-sm-7">RON/fő/alkalom</label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </table>
            <br>
            <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
        </form>
    </div>
</div>
<?php if($params['info'] === "wellnessUpdated"): ?>
    <a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szolgaltatasok?#editWellnessForm" style="text-decoration:none">
        <div class="alert alert-success text-center mb-3 m-5" id="editWellnessMessage">
            Wellness frissítve!
        </div>
    </a>
<?php elseif($params['info'] === "wellnessEmptyPrice"): ?>
<a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szolgaltatasok?#editWellnessForm" style="text-decoration:none">
    <div class="alert alert-danger text-center mb-3 m-5" id="editWellnessMessage">
        Add meg a wellness árát!
    </div>
</a>
<?php elseif($params['info'] === "wellnessFacilitiesNotSpecified"): ?>
<a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szolgaltatasok?#editWellnessForm" style="text-decoration:none">
    <div class="alert alert-danger text-center mb-3 m-5" id="editWellnessMessage">
        Add meg a wellness részleteit!
    </div>
</a>
<?php endif; ?>
<div class="card border-success mb-3 m-5" id="editWellnessForm">
    <div class="card-header">Wellness</div>
    <div class="card-body">
    <form class="form-inline" action="/update-wellness/<?= $params['accm']['id'] ?>" method="POST">
            <div class="container row">            
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="wellnessOffered">
                    <input class="form-check-input" type="radio"  name="wellnessOffered" value="YES" <?= $params['accm']['wellness_offered'] === "YES" ? "checked" : "" ?>>
                        Biztosítok wellnesst
                    </label>
                </div>
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="wellnessOffered">
                    <input class="form-check-input" type="radio"  name="wellnessOffered" value="NO" <?= $params['accm']['wellness_offered'] !== "YES" ? "checked" : "" ?>>
                        Nem biztosítok wellnesst 
                    </label>
                </div>
            </div>
            <hr style="border: 1px dashed white">
            <div class=" container row">
                <p class="mt-4">Milyen szolgáltatásokat biztosítasz?</p>
                <?php foreach($params['wellnessFacilities'] as $wellnessFacility) : ?>
                    <div class="form-check" style="max-width: 10rem;">
                        <label class="form-check-label" for="wellnessFacilities">
                        <input class="form-check-input" type="checkbox"  name="<?= $wellnessFacility['value']?>" value="YES" <?= $params['accm'][$wellnessFacility['value']] === "YES" ? "checked": "" ?>>
                            <?= $wellnessFacility['name']?>
                        </label>
                    </div>                                    
                <?php endforeach; ?>
            </div>
            <hr style="border: 1px dashed white">
            <div class="container">
                <p class="mt-4">Mennyibe kerül?</p>
                <?php foreach($params['wellnessStatus'] as $wellnessStatus): ?>
                    <div class="row">          
                        <div class="form-check" style="max-width: 15rem;">
                            <label class="form-check-label" for="wellnessStatus">
                            <input class="form-check-input" type="radio"  name="wellnessStatus" value="<?= $wellnessStatus['value'] ?>" <?= @$params['accm']['wellness_status'] === $wellnessStatus['value'] ? "checked" : "" ?>>
                                <?= $wellnessStatus['name'] ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach;?>
                <div class="row">
                    <div class="col-sm-1">
                        <input class="form-control form-control-sm" type="text" name="wellnessPrice" value="<?= @$params['accm']['wellness_price'] ?>" autocomplete="off"/>
                    </div>
                    <label for="wellnessPrice" class="col-sm-2">RON/fő/alkalom</label>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
        </form>
    </div>
</div>
<div class="card border-success m-5">
    <div class="card-header">Szolgáltatások és felszereltség</div>
    <div class="card-body">
    </div>
</div>