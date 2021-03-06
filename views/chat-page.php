<?php if($params['info'] === 'deleted'): ?>
    <a href='/chat' style="text-decoration:none">
        <div class="alert alert-danger text-center">
            Beszélgetés törölve!
        </div>
    </a>
<?php endif ?>
<form class="form-inline form-group" action="/new-conversation" method="POST" id="newMessage">
    <button type="submit" class="btn btn-sm btn-success float-end">Új üzenet</button>
</form>
<hr>
<?php foreach($params['conversationsWithMessages'] as $conversation): ?>
    <div class="container" id="<?php echo $conversation['id']?>">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary mb-3" style="max-width: 40rem;">
                    <div class="card-header container">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $conversation['name'] ?>
                                </div>
                                <div class="col-md-4">
                                    <form action="/delete-conversation?id=<?= $conversation['id'] ?>" method="POST">
                                        <button type="submit" class="btn btn-sm btn-danger float-end">X</button>
                                    </form>
                                    <a href="/chat?manage-members=<?= $conversation['id']?>&href=#<?php echo $conversation['id']?>">
                                        <button class="btn btn-sm btn-primary float-end">Tagok</button>
                                    </a>                    
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-body" style="overflow: auto; height:200px; display: flex; flex-direction: column-reverse;">
                            <?php foreach($conversation['messages'] as $message): ?>
                                <div>
                                    <small style="font-size:0.8rem" <?= $message['from_user_id'] === $params['userId'] ? 'class=' . 'float-end' : ''?>><?=$message['sender'] . ' (' . date('Y.m.d H:i', $message['sent_at']) . '):' ?></small><br>
                                    <span class="badge rounded-pill bg-<?= $message['from_user_id'] === $params['userId'] ? 'info float-end' : 'secondary' ?>"><?= $message['message'] ?></span><br>
                                    <?php if($message['from_user_id'] === $params['userId'] AND $message['seen'] === '1'):?>
                                        <i><small class="float-end" style="font-size:0.6rem">Látta: <?= date('Y.m.d H:i', $message['seen_at']) ?></small></i>
                                    <?php endif;?>
                                </div>
                                <br>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    <hr>
                    <form action="send-message?convId=<?= $conversation['id'] ?>" method="POST">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-control form-control-sm" name="message" placeholder="Írj üzenetet" autocomplete="off">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-sm btn-success">Küldés</button>
                                </div>
                                <br>
                                <br>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
            <?php if($params['manageMembers'] === $conversation['id']):?>
                <div class="card border-primary mb-3" style="max-width: 20rem;">
                    <div class="card-header container">
                        Tagok kezelése
                        <a href="/chat?href=#<?=$conversation['id']?>">
                            <button class="btn btn-sm btn-danger float-end">X</button>
                        </a> 
                    </div>
                    <div class="card-body" style="overflow: auto; height:200px">
                        <form action="/add-member?convId=<?= $conversation['id']?>" method="POST">
                            <select name="member">
                                <option value="none" selected disabled hidden>Kiválasztás</option>
                                <?php foreach($params['allUsers'] as $user): ?>
                                    <option value="<?php  echo $user['id']?>"> <?php echo $user['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">Hozzáad</button>
                        </form>
                        <hr>
                        <?php foreach($params['convMembers'] as $convMember): ?>
                            <?php if($convMember['conversation_id'] === $conversation['id']): ?>
                                <?= $convMember['name']?>
                                <form action="/delete-member?convId=<?= $conversation['id'] . '&convMember=' . $convMember['member_user_id'] ?>" method="POST">
                                    <button type="submit" class="btn btn-danger rounded-pill btn-sm">Eltávolítás</button>
                                </form>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <hr>
<?php endforeach; ?>