<?php if($params['info'] === "added"): ?>
    <a href="/szallasok/<?= $params['accm']['slug'] ?>/beallitasok/szobak" style="text-decoration:none">
        <div class="alert alert-success text-center mb-3 m-5">
            Szoba létrehozva!
        </div>
    </a>
<?php elseif($params['info'] === "deleted"): ?>
    <a href="/szallasok/<?= $params['accm']['slug'] ?>/beallitasok/szobak" style="text-decoration:none">
        <div class="alert alert-danger text-center mb-3 m-5">
            Szoba törölve!
        </div>
    </a>
<?php endif; ?>
<div class="card border-success mb-3 m-5">
    <div class="card-header">Szobák listája</div>
    <div class="card-body">
        <a href="/szallasok/<?= $params['accm']['slug']?>/beallitasok/szobak/uj-szoba" >
            <button class="btn btn-sm btn-outline-success float-end">Új egység</button>
        </a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Megnevezés</th>
                    <th>Típus</th>
                    <th>Darab</th>
                    <th>Művelet</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($params['units'] as $unit): ?>
                    <tr>
                        <td><?= $unit['name'] ?></td>
                        <td><?= ($unit['unit_type'] === "room" ? "szoba" : ($unit['unit_type'] === "apartment" ? "apartman" : ($unit['unit_type'] === "complete" ? "Teljes " . $params['accm']['type'] : ""))) ?></td>
                        <td><?= $unit['count'] ?></td>
                        <td>
                        <div class="btn-group">
                            <a href="/szallasok/<?= $params['accm']['slug'] ?>/beallitasok/szobak/szoba-szerkesztese/<?= $unit['id'] ?>">
                                <button class="btn btn-sm btn-warning">Szerkesztés</button>
                            </a>
                        
                            <form action="/delete-unit/<?= $unit["id"] ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-danger">X</button>
                            </form>
                        </div>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>