<div class="card container p-5 m-5">
    <?php if($params['isAdded']): ?>
        <div class="alert alert-success">
            Csomag létrehozva!
        </div>
    <?php elseif($params['isUpdated']): ?>
        <div class="alert alert-success">
            Csomag sikeresen frissítve!
        </div>
    <?php elseif($params['isDeleted']): ?>
        <div class="alert alert-danger">
            Csomag sikeresen törölve!
        </div>
    <?php elseif($params["isReserved"]): ?>
        <div class="alert alert-success">
            Sikeres foglalás!
        </div>
    
    <?php endif ?>
    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
        <?php if($params['newPackage']):?>
            <form action="/csomagok" method="POST">
                <input type="text" name="name" placeholder="Szállás" autocomplete="off"/>
                <input type="text" name="location" placeholder="Település" autocomplete="off"/>
                <input type="text" name="price" placeholder="Ár (/fő/éj)" autocomplete="off"/>
                <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                <a href="/csomagok">
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2">Mégse</button>
                </a>
            </form> 
        <?php else: ?>
            <a href="/csomagok?add=1">
                <button class="btn btn-sm btn-primary float-end">Új csomag</button>
            </a>
        <?php endif; ?>
    <?php endif; ?>
    <hr>
    <div class="row">
        <?php foreach($params['packages'] as $package): ?>
            <div class="card border-success ms-auto mb-5 me-auto col-auto" id="<?php echo $package['id']?>" style="max-width:20rem">
                    <div class="card-header container-fluid h4">
                        <?php echo $package['name'] . " " . $package['location'];?>
                    </div>
                <div class="card-body container-fluid">
                    <div class="align-middle">    
                        <?php if(isset($package['image'])): ?>
                            <img class="img-fluid img-thumbnail" src="<?php echo $package['image']?>" alt="<?php echo $package['name'] ?>" style="width:318px">
                        <?php endif; ?>
                    </div>
                    <br>
                    <br>
                        <a href="/csomagok/<?php echo $package["slug"] ?>">
                            <button class="btn btn-sm btn-outline-success float-end">Részletek</button>
                        </a>
                        <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                            <form action="/delete-package/<?php echo $package['id'] ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-danger float-end">Törlés</button>
                            </form>
                        <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
        <hr>
        <a href="/csomagok?add=1">
            <button class="btn btn-sm btn-primary float-end">Új csomag</button>
        </a>
    <?php endif; ?>
</div>