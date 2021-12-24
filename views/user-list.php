<div class="card p-5 m-5">
    <?php if($params['isAdded']): ?>
        <div class="alert alert-success">
            Felhasználó sikeresen hozzáadva!
        </div>
    <?php elseif($params['isUpdated']): ?>
        <div class="alert alert-success">
            Felhasználó frissítve!
        </div>
    <?php elseif($params['isDeleted']): ?>
        <div class="alert alert-danger">
            Felhasználó törölve!
        </div>
    
    <?php endif ?>

    
    <form action="/add-user" method="POST">
        <input type="text" name="name" placeholder="Név" autocomplete="off"/>
        <input type="text" name="email" placeholder="Email" autocomplete="off"/>
        <input type="password" name="password" placeholder="Jelszó" autocomplete="off"/>
        <button type="submit" class="btn btn-sm btn-success">Küldés</button>
    </form>
    <br>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Név</th>
                <th>Email</th>
                <th>Regisztráció dátuma</th>
                <th>Admin</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($params['users'] as $user) : ?>
                <tr>
                <td><?php echo $user["name"]?></td>
                <td><?php echo $user["email"]?></td>
                <td><?php echo date('Y.m.d H:i' , $user["createdAt"])?></td>
                <td><?php echo $user["isAdmin"] === "1" ? "Igen": "Nem"?></td>
                
                <?php if($params["editedUserId"] === $user["id"]) : ?>
                    <td>
                        <form class="form-inline form-group" action="/update-user?id=<?php echo $user["id"]?>" method="post">
                            <input class="form-control form-control-sm mr-2" type="text" name="name" placeholder="Név" value="<?php echo $user["name"] ?>" autocomplete="off"/>
                            <input class="form-control form-control-sm mr-2" type="text" name="email" placeholder="Email" value="<?php echo $user["email"] ?>" autocomplete="off"/>
                            <label for="isAdmin" class="form-label mt-4">Admin:</label>
                            <select class="" name="isAdmin" id="isAdmin">
                                <option value="1" <?php echo $user['isAdmin'] === "1" ? "selected" : ""?>>Igen</option>
                                <option value="0" <?php echo $user['isAdmin'] === "0" ? "selected" : ""?>>Nem</option>
                            </select>

                            <a href="/felhasznalok">
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2">Mégse</button>
                            </a>

                            <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                        </form>

                    </td>
                               
                <?php else: ?>
                <td>
                    <div class="btn-group">
                        <a href="/felhasznalok?edit=<?php echo $user["id"] ?>">
                            <button class="btn btn-sm btn-warning">Szerkesztés</button>
                        </a>
                    
                        <form action="/delete-user?id=<?php echo $user["id"] ?>" method="post">
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