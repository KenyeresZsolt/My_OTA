<div class="card container p-5 m-5">
    <?php if($params['isDeleted']): ?>
        <div class="alert alert-success">
            Foglalás törölve!
        </div>
    <?php elseif($params['isUpdated']): ?>
        <div class="alert alert-success">
            Foglalás frissítve!
        </div>
    <?php endif; ?>
    <?php foreach($params['reservations'] as $reservation): ?>
        <div class="accordion" id="accordionExample">
            <div class="card">               
                    <h2 class="accordion-header" id="heading<?php echo $reservation['id']?>">
                        <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse<?php echo $reservation['id']?>" aria-expanded="true" aria-controls="collapse<?php echo $reservation['id']?>">
                            Név: <?php echo $reservation['name']?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $reservation['id']?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo $reservation['id']?>" data-parent="#accordionExample">
                        <div class="accordion-body">
                            <h4 class="card-text">Lefoglalt szállás:
                                <?php
                                    foreach($params['packages'] as $package)
                                        if($package['id'] === $reservation['reservedPackageId']){
                                            echo $package['name'] . " " . $package['location'];
                                        }
                                ?>
                            </h4>
                            <h4>
                                <?php if($reservation['status'] === 'RESERVED'): ?>
                                    <span class="card-text badge rounded-pill bg-success"><?= "Lefoglalva" ?></span>
                                <?php elseif($reservation['status'] === 'CANCELED'): ?>
                                    <span class="card-text badge rounded-pill bg-danger"><?= "Lemondva" ?></span>
                                <?php endif; ?>                            
                            </h4>
                            <h4><span class="card-text badge rounded-pill bg-light">Ár: <?php echo $reservation['totalPrice'] . " lej" ?></span></h4>
                            <p><span class="card-text badge rounded-pill bg-light">Email: <?php echo $reservation['email']?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Telefonszám: <?php echo $reservation['phone']?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Foglalás időpontja: <?php echo date("Y.m.d H:i", $reservation['reserved'])?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Bejelentkezés: <?php echo $reservation['checkin']?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Kijelentkezés: <?php echo $reservation['checkout']?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Éjszakák száma: <?php echo $reservation['nights']?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Vendégek száma: <?php echo $reservation['guests']?></span></p>
                            <p><span class="card-text badge rounded-pill bg-light">Azonosító: <?php echo $reservation['id']?></span></p> 
                            
                            <?php if($params["updateReservationId"] === $reservation["id"]) : ?>
                                <form class="form-inline form-group" action="/update-reservation?id=<?php echo $reservation["id"] ?>" method="POST" >
                                    <input type="text" name="name" placeholder="Név" value="<?php echo $reservation["name"] ?>" autocomplete="off"/>
                                    <input type="number" name="price" placeholder="Ár" value="<?php echo $reservation["totalPrice"] ?>" autocomplete="off"/>
                                    <input type="text" name="email" placeholder="Email" value="<?php echo $reservation["email"] ?>" autocomplete="off"/>
                                    <input type="text" name="phone" placeholder="Telefonszám" value="<?php echo $reservation["phone"] ?>" autocomplete="off"/>
                                    <input type="date" name="checkin" placeholder="Érkezés" value="<?php echo $reservation["checkin"] ?>" autocomplete="off"/>
                                    <input type="date" name="checkout" placeholder="Távozás" value="<?php echo $reservation["checkout"] ?>" autocomplete="off"/>
                                    <input type="number" name="guests" placeholder="Vendégek" value="<?php echo $reservation["guests"] ?>" autocomplete="off"/>
                                    <br>
                                    <br>
                                    <div class="btn-group float-end">
                                        <a href="/foglalasok">
                                            <button type="button" class="btn btn-sm btn-outline-primary mr-2">Vissza</button>
                                        </a>

                                        <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                                    </div>
                                </form>
                            <?php else:?>
                            <form action="/delete-reservation?id=<?php echo $reservation["id"] ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-danger float-end">Törlés</button>
                            </form>
                            <?php if($reservation['status'] === 'RESERVED'): ?>
                                <form action="/cancel-reservation?id=<?php echo $reservation["id"] ?>" method="post">
                                    <button type="submit" class="btn btn-sm btn-danger float-end">Lemondom</button>
                                </form>
                            <?php endif;?>
                            <a href="/foglalasok?edit=<?php echo $reservation["id"] ?>">
                                <button class="btn btn-sm btn-light float-end">Szerkesztés</button>
                            </a>
                               
                            <?php endif;?>
                            <br>
                            <br>
                        </div>
                    </div>
                
            </div>                    
        </div>
        <hr>
    <?php endforeach; ?>
</div>