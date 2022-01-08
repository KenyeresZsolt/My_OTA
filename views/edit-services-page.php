<div class="card border-success mb-3 m-5">
    <div class="card-header">Étkezés</div>
    <div class="card-body">
        <form class="form-inline" action="/update-meals/<?= $params['package']['id'] ?>" method="POST">
            <div class="container row">            
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="mealOffered">
                    <input class="form-check-input" type="radio"  name="mealOffered" value="YES" <?= $params['package']['meal_offered'] === "YES" ? "checked" : "" ?>>
                        Biztosítok étkezést
                    </label>
                </div>
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="mealOffered">
                    <input class="form-check-input" type="radio"  name="mealOffered" value="NO" <?= $params['package']['meal_offered'] !== "YES" ? "checked" : "" ?>>
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
                                            <input class="form-check-input" type="radio"  name="<?= $meal['value'] ?>" value="<?= $mealStatus['value'] ?>" <?= (($mealStatus['value'] === @$params['mealDetails'][$meal['value']]) OR ($params['package']['meal_offered'] !== "YES" AND $mealStatus['value'] === "NOTPROVIDED"))  ? "checked" : "" ?>>
                                                <?= $mealStatus['name'] ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input class="form-control form-control-sm" type="text" name="<?= $meal['value'] ?>Price" value="<?= @$params['mealDetails'][$meal['value'] . "Price"] ?>" autocomplete="off"/>
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
<div class="card border-success mb-3 m-5">
    <div class="card-header">Wellness</div>
    <div class="card-body">
    <form class="form-inline" action="/update-wellness/<?= $params['package']['id'] ?>" method="POST">
            <div class="container row">            
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="wellnessOffered">
                    <input class="form-check-input" type="radio"  name="wellnessOffered" value="YES" <?= $params['package']['wellness_offered'] === "YES" ? "checked" : "" ?>>
                        Biztosítok wellnesst
                    </label>
                </div>
                <div class="form-check" style="max-width: 15rem;">
                    <label class="form-check-label" for="wellnessOffered">
                    <input class="form-check-input" type="radio"  name="wellnessOffered" value="NO" <?= $params['package']['wellness_offered'] !== "YES" ? "checked" : "" ?>>
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
                        <input class="form-check-input" type="checkbox"  name="wellnessFacilities[]" value="<?= $wellnessFacility['value']?>" <?= !is_array(@$params['wellnessDetails']['wellnessFacilities']) ? "" : in_array($wellnessFacility['value'], $params['wellnessDetails']['wellnessFacilities']) ? "checked" : "" ?>>
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
                            <input class="form-check-input" type="radio"  name="wellnessStatus" value="<?= $wellnessStatus['value'] ?>" <?= @$params['wellnessDetails']['wellnessStatus'] === $wellnessStatus['value'] ? "checked" : "" ?>>
                                <?= $wellnessStatus['name'] ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach;?>
                <div class="row">
                    <div class="col-sm-1">
                        <input class="form-control form-control-sm" type="text" name="wellnessPrice" value="<?= @$params['wellnessDetails']['wellnessPrice'] ?>" autocomplete="off"/>
                    </div>
                    <label for="wellnessPrice" class="col-sm-2">RON/fő/nap</label>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-success float-end">Lementem</button>
        </form>
    </div>
</div>
<div class="card border-success mb-3 m-5">
    <div class="card-header">Szolgáltatások és felszereltség</div>
    <div class="card-body">
    </div>
</div>