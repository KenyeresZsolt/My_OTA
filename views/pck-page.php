<div class="card p-5 m-5">
    <a href="/csomagok">
        <button class="btn btn-sm btn-outline-success">Vissza</button>
    </a>
    <br>
    <div class="card border-success mb-3" id="<?php echo $params['package']['id']?>">
        <h4><div class="card-header"><?php echo $params['package']['name'] . " " . $params['package']['location'];?> </div></h4>
            <div class="card-body container">
                <div class="row">
                        <?php if(isset($params['package']['image'])): ?>
                            <img src="<?php echo $params['package']['image']?>" alt="<?php echo $params['package']['name'] ?>" style="width:50%" class="align-right">
                        <?php endif; ?>
                </div>
                <br>
                <br>   
                    <div class="">
                        <p><?php echo @$params['package']['description']; ?> </p>
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
                    </div>
                <br>
                <br>
                
                <?php if($params["updatePackageId"]) : ?>
                    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                        <form class="form-inline form-group" action="/update-package/<?php echo $params['package']["id"] ?>" method="POST" id="pckUpdate">
                            <input type="text" name="name" placeholder="Szállás" value="<?php echo $params['package']["name"] ?>" autocomplete="off"/>
                            <input type="text" name="location" placeholder="Település" value="<?php echo $params['package']["location"] ?>" autocomplete="off"/>
                            <input type="number" name="price" placeholder="Ár" value="<?php echo $params['package']["price"] ?>"/>
                            <input type="number" name="discount" placeholder="Kedvezmény(%)" value="<?php echo $params['package']["discount"] ?>" autocomplete="off"/>
                            <div class="form-group">
                                <label for="description" class="form-label mt-4">Leírás:</label>
                                <textarea class="form-control" id="description" name="description" form="pckUpdate" rows="3"><?php echo @$params['package']["description"] ?></textarea>
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
                    <?php endif; ?>
                <?php elseif($params["addImgToPckId"]): ?>
                    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                        <form action="/upload-pck-image/<?php echo $params['package']["id"] ?>" method="post" enctype="multipart/form-data">
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
                    <div class="card border-primary mb-3">
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
                            <a href="/csomagok/<?php echo $params['package']["slug"] ?>?addimage=1">
                                <button class="btn btn-sm btn-light">Kép hozzáadása</button>
                            </a>

                            <a href="/csomagok/<?php echo $params['package']["slug"] ?>?edit=1">
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