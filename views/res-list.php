<?php if($params['info'] === "deleted"): ?>
    <a href="/foglalasok" style="text-decoration:none">
        <div class="alert alert-success text-center">
            Foglalás törölve!
        </div>
    </a>
<?php elseif($params['info'] === "updated"): ?>
    <a href="/foglalasok" style="text-decoration:none">
        <div class="alert alert-success text-center">
            Foglalás frissítve!
        </div>
    </a>
<?php endif; ?>
<div class="card border-success mb-3 m-5">
    <div class="card-header">Foglalások</div>
    <div class="card-body">
        <table class="table table-hover">
            <tr>
                <th>Azonosító</th>
                <th>Név</th>
                <th>Szállás</th>
                <th>Foglalás dátuma</th>
                <th>Bejelentkezés</th>
                <th>Kijelentkezés</th>
                <th>Ár</th>
                <th>Művelet</th>

            </tr>
            <?php foreach($params['reservations'] as $reservation): ?>
                <tr>
                    <td><?= $reservation['id']?></td>
                    <td><?= $reservation['name']?></td>
                    <?php foreach($params['accms'] as $accm):?>
                        <?php if($accm['id'] === $reservation['reserved_accm_id']): ?>
                            <td><?=$accm['name'] . " " . $accm['location']?></td>
                        <?php endif; ?>
                    <?php endforeach;?>
                    <td><?= date('Y.m.d H:i:m' ,$reservation['reserved'])?></td>
                    <td><?= $reservation['checkin']?></td>
                    <td><?= $reservation['checkout']?></td>
                    <td><?= $reservation['total_price'] . " lej"?></td>
                    <td>
                        <div class="btn-group">
                            <a href="/foglalasok/<?= $reservation['id'] ?>">
                                <button class="btn btn-sm btn-warning">Megnyit</button>
                            </a>
                        
                            <form action="/delete-reservation?id=<?php echo $user["id"] ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-danger">X</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>   
    </div>
</div>