<div class="card p-5 m-5">
    <a href="/csomagok">
        <button class="btn btn-sm btn-outline-success">Vissza</button>
    </a>
    <br>
    <?php if($params['info'] === "updated"): ?>
        <div class="alert alert-success">
            Csomag frissítve!
        </div>
    <?php elseif($params["info"] === "reserved"): ?>
        <div class="alert alert-success">
            Sikeres foglalás!
        </div>
    <?php endif ?>
    <div class="card border-primary mb-3" id="<?php echo $params['package']['id']?>">
        <h4><div class="card-header"><?php echo $params['package']['name'] . " " . $params['package']['location'];?> </div></h4>
            <div class="card-body container">
                <div class="row">
                    <?php if(isset($params['package']['image'])): ?>
                        <img src="<?php echo $params['package']['image']?>" alt="<?php echo $params['package']['name'] ?>" style="width:50%" class="align-right">
                    <?php endif; ?>
                    <div class="col-md-6">
                        <h4>Ár/fő/éj:
                            <?php 
                                if(empty($params['package']['disc_price'])){
                                    echo "<span class=" . '"badge bg-success"' . ">" . $params['package']['price'] . " lej</span>";
                                }
                                else {
                                    echo "<span class=" . '"badge bg-danger"' . "><strike>" . $params['package']['price'] . " lej</strike></span> " . "<span class=" . '"badge bg-success"' . ">" . $params['package']['disc_price'] . " lej</span>";
                                }
                            ?>
                        </h4>
                        <p>
                            <?php
                                if(empty($params['package']['disc_price'])){
                                }
                                else {
                                    echo '<span class="badge bg-info">Kedvezmény: -' . $params['package']['discount'] . "%</span>";
                                }
                            ?>
                        </p>
                        <p><?= "Típus: " . $params['package']['type']?></p>
                    </div>
                </div>
                <br>
                <br>   
                    <div class="row">
                        <p><?php echo @$params['package']['description']; ?> </p>
                    </div>
                <br>
                <br>
                
                <?php if($params["updatePackageId"]) : ?>
                    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                        <div class="card border-success mb-3">
                            <div class="card-header">Szállás szerkesztése</div>
                            <div class="card-body">
                                <form class="form-inline" action="/update-package/<?php echo $params['package']["id"] ?>" method="POST" id="pckUpdate">
                                    <div class="form-group">
                                        <div class="row">
                                            <div style="max-width: 15rem;">
                                                <label for="name" class="form-label mt-4">Szállás neve</label>
                                                <input class="form-control" type="text" name="name" value="<?php echo $params['package']["name"] ?>" autocomplete="off"/>                                        
                                            </div>
                                            <div style="max-width: 15rem;">
                                                <label for="email" class="form-label mt-4">Település</label>
                                                <input class="form-control" type="text" name="location" value="<?php echo $params['package']["location"] ?>" autocomplete="off"/>                                        
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <label for="type" class="form-label mt-4">Szálláshely típusa</label>
                                                <?php foreach($params['accmTypes'] as $accmType) : ?>
                                                    <div class="form-check">
                                                    <label class="form-check-label" for="type">
                                                        <input class="form-check-input" type="radio"  name="type" value="<?= $accmType['typeCode']?>" <?= $accmType['typeCode'] === $params['package']["accm_type"] ? "checked" : "" ?>>
                                                        <?= $accmType['name']?>
                                                    </label>
                                                </div>
                                                <?php endforeach; ?>                                          
                                        </div>
                                        <div class="row">
                                            <div style="max-width: 15rem;">
                                                <label for="phone" class="form-label mt-4">Ár</label>
                                                <input class="form-control" type="text" name="price" value="<?php echo $params['package']["price"] ?>" autocomplete="off"/>                                        
                                            </div>
                                            <div style="max-width: 15rem;">
                                                <label for="guests" class="form-label mt-4">Kedvezmény(%)</label>
                                                <input class="form-control" type="text" name="discount" value="<?php echo $params['package']["discount"] ?>" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="description" class="form-label mt-4">Leírás</label>
                                            <textarea class="form-control" id="description" name="description" form="pckUpdate" rows="3"><?php echo @$params['package']["description"] ?></textarea>
                                        </div>
                                    <br>
                                    <br>
                                    <div class="btn-group float-end">
                                        <a href="/csomagok/<?php echo $params['package']["slug"]?>">
                                            <button type="button" class="btn btn-sm btn-outline-primary mr-2">Vissza</button>
                                        </a>

                                        <button type="submit" class="btn btn-sm btn-success">Mentés</button>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php elseif($params["addImgToPckId"]): ?>
                    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                        <form action="/upload-pck-image/<?php echo $params['package']["id"] ?>" method="post" enctype="multipart/form-data" id="addImg">
                            <input class="form-control col-md-2" type="file" name="fileToUpload" id="fileToUpload">
                            <br>
                            <input class="btn btn-sm btn-success" type="submit" value="Feltöltés" name="submit">
                            <a href="/csomagok/<?php echo $params['package']["slug"]?>">
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2">Mégse</button>
                            </a>
                        </form>
                    <?php endif; ?>
                
                <?php elseif($params["resPackageId"]): ?>
                    <?php if($params['info'] === "emptyValue"): ?>
                        <div class="alert alert-danger mb-3" style="max-width: 20rem;" id="infoMessage">
                            Tölts ki minden mezőt!
                        </div>
                    <?php endif; ?>
                    <div class="card border-success mb-3">
                        <div class="card-header">Küldd el foglalásod most! </div>
                        <div class="card-body">
                            <p class="card-title">Add meg az adataidat:</p>
                            <form class="form-inline" action="/reserve-package/<?php echo $params['package']["id"] ?>" method="POST" id="resForm">
                                <div class="form-group">
                                    <div class="row">
                                        <div style="max-width: 15rem;">
                                            <label for="name">Név</label>
                                            <input class="form-control" type="text" name="name" value="<?= $params['values']['name'] ?? '' ?>" autocomplete="off"/>                                        
                                        </div>
                                        <div style="max-width: 15rem;">
                                            <label for="email">Email</label>
                                            <input class="form-control" type="text" name="email" value="<?= $params['values']['email'] ?? '' ?>" autocomplete="off"/>                                        
                                        </div>
                                        <div style="max-width: 15rem;">
                                            <label for="phone">Telefonszám</label>
                                            <input class="form-control" type="text" name="phone" value="<?= $params['values']['phone'] ?? '' ?>" autocomplete="off"/>                                        
                                        </div>
                                        <div style="max-width: 15rem;">
                                            <label for="guests">Személyek száma</label>
                                            <input class="form-control" type="number" name="guests" min="1" value="<?= $params['values']['guests'] ?? '' ?>" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div style="max-width: 15rem;">
                                            <label for="checkin">Érkezés dátuma</label>
                                            <input class="form-control" type="date" name="checkin" min="<?php echo date("Y-m-d"); ?>" value="<?= $params['values']['checkin'] ?? '' ?>" autocomplete="off"/>
                                        </div>
                                        <div style="max-width: 15rem;">
                                            <label for="checkout">Távozás dátuma</label>
                                            <input class="form-control" type="date" name="checkout" min="<?php echo date("Y-m-d"); ?>" value="<?= $params['values']['checkout'] ?? '' ?>" autocomplete="off"/>
                                        </div>
                                    </div>
                                <br>
                                <br>
                                <div class="btn-group float-end">
                                    <a href="/csomagok/<?php echo $params['package']["slug"]?>">
                                        <button type="button" class="btn btn-sm btn-outline-primary mr-2">Vissza</button>
                                    </a>

                                    <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                                </div> 
                            </form>
                        </div>
                    </div>
                

                <?php else: ?>
                
                    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                        <div class="btn-group">
                            <a href="/csomagok/<?php echo $params['package']["slug"] ?>?addimage=1#addImg">
                                <button class="btn btn-sm btn-light">Kép hozzáadása</button>
                            </a>

                            <a href="/csomagok/<?php echo $params['package']["slug"] ?>?edit=1#pckUpdate">
                                <button class="btn btn-sm btn-light">Szerkesztés</button>
                            </a>
                                
                            <form action="/delete-package/<?php echo $params['package']["id"] ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-danger">Törlés</button>
                            </form>
                        </div>
                    <?php endif; ?>
                        <a href="/csomagok/<?php echo $params['package']["slug"] ?>?res=1?href=#resForm">
                            <button class="btn btn-sm btn-success float-end">Lefoglalom</button>
                        </a>
                    <?php endif; ?>
            </div>
        </div>
</div>