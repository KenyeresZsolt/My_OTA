<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/public/bootstrap.css">
    <link rel="stylesheet" href="/public/TM_design.css">
    <link rel="stylesheet" href="/public/sakktabla.css">
    <link rel="stylesheet" href="/public/image_slideshow.css">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
    <title><?php echo $params['title']?></title>
    <?php if($params['activeLink'] === '/chat'): ?>
        <meta http-equiv="refresh" content="30">
    <?php endif; ?>
    <link rel="icon" href="/public/icons/browser-tab.png">
</head>
<body class="TM_body" style="padding-bottom: 70px;">
    <?php if($params['playChatSound']): ?>
    <audio controls autoplay style="display:none;">
        <source src="public/audio/chat.wav" type="audio/wav">
    </audio>
    <?php endif ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-navbar">
        <div class="container">
            <div class="navbar-nav">
                <a class="nav-item nav-link <?php echo $params['activeLink'] === "/" ? "active" : "" ?>" href="/">
                    Főoldal
                </a>
                <a class="nav-item nav-link <?php echo $params['activeLink'] === "/szallasok" ? "active" : "" ?>" href="/szallasok">
                    Szállások
                </a>
                <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                    <a class="nav-item nav-link <?php echo $params['activeLink'] === "/foglalasok" ? "active" : "" ?>" href="/foglalasok">
                        Foglalások
                    </a>
                <?php endif;?>
            </div>
            <?php if($params['isAuthorized']): ?>
                <div class="btn-group">
                    <a href="/profil">    
                        <button type="submit" class="btn btn-sm btn-light float-end <?php echo $params['activeLink'] === "/profil" ? "active" : "" ?>">Profil</button>
                    </a>
                    <a class="btn btn-sm btn-light float-end" href="/chat">
                        Chat <?= "(" . $params['unreadMessages'] . ")"?>
                    </a>
                    <form action="/kijelentkezes" method="POST">
                            <button type="submit" class=" btn btn-sm btn-danger float-end">Kijelentkezés</button>
                    </form>
                </div>
            <?php else: ?>
                <form action="/bejelentkezes" method="POST">
                        <button type="submit" class=" btn btn-sm btn-light float-end">Bejelentkezés</button>
                </form>
            <?php endif;?>
        </div>
    </nav>
    <div class="card p-5 m-5">
        <?php echo $params['content'] ?>
    </div>
    <footer class="bg-secondary text-lg-start fixed-bottom container-fluid" style="font-size:1vw;">
            <div class="row">
                <div class="text-center p-3 text-white" style="max-width: 92%;">
                    @Kenyeres Zsolt
                </div>
                <div class="float-end p-3" style="max-width: 8%;">
                    <a class="nav-item" href="/kapcsolat" style="text-decoration: none; color:white">Kapcsolat</a>
                </div>
            </div>
    </footer>
</body>
</html>