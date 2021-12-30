<div class="card container p-5 m-5">
    <?php if($params['info'] === "added"): ?>
        <div class="alert alert-success">
            Hero sikeresen hozzáadva!
        </div>
    <?php elseif($params['info'] === "updated"): ?>
        <div class="alert alert-success">
            Hero sikeresen frissítve!
        </div>
    <?php elseif($params['info'] === "deleted"): ?>
        <div class="alert alert-danger">
            Hero sikeresen törölve!
        </div>
    
    <?php endif ?>

    
    <form action="/hero" method="POST">
        <input type="text" name="name" placeholder="Név" autocomplete="off" />
        <input type="text" name="email" placeholder="Email" autocomplete="off" />

        <select name="department" class="">
            <option value="none" selected disabled hidden>Részleg:</option>

            <?php foreach($params['departments'] as $department): ?>
                <option value="<?php  echo $department['name']?>"> <?php echo $department['name'] ?> </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-sm btn-success">Küldés</button>
    </form>
    <br>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Név</th>
                <th>Email</th>
                <th>Részleg</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($params['heroes'] as $hero) : ?>
                <tr id="<?php echo $hero["id"]?>">
                <td><?php echo $hero["name"]?></td>
                <td><?php echo $hero["email"]?></td>
                <td><?php echo $hero["department"]?></td>
                
                <?php if($params["editedHeroId"] === $hero["id"]) : ?>
                    <td>
                        <form class="form-inline form-group" action="/update-hero?id=<?php echo $hero["id"]?>" method="post">
                            <input class="form-control form-control-sm mr-2" type="text" name="name" placeholder="Név" autocomplete="off" value="<?php echo $hero["name"] ?>" />
                            <input class="form-control form-control-sm mr-2" type="text" name="email" placeholder="Email" autocomplete="off" value="<?php echo $hero["email"] ?>" />
                            <select name="department" class="form-label mt-2">
                                    <?php foreach($params['departments'] as $department): ?>
                                        <option value="<?php  echo $department['name']?>" <?php echo $department['name'] === $hero['department'] ? "selected" : ""?>> <?php echo $department['name'] ?> </option>
                                    <?php endforeach; ?>
                            </select>

                            <a href="/hero">
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2">Mégse</button>
                            </a>

                            <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                        </form>

                    </td>
                               
                <?php else: ?>
                <td>
                    <div class="btn-group">
                        <a href="/hero?edit=<?php echo $hero["id"] ?>#<?php echo $hero["id"] ?>">
                            <button class="btn btn-sm btn-warning">Szerkesztés</button>
                        </a>
                    
                        <form action="/delete-hero?id=<?php echo $hero["id"] ?>" method="post">
                            <button type="submit" class="btn btn-sm btn-danger">X</button>
                        </form>
                    </div>
                </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
       
</div>