<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/public/bootstrap.css">
    <link rel="stylesheet" href="/public/TM_design.css">
    <link rel="stylesheet" href="/public/sakktabla.css">
    <title><?php echo $params['title']?></title>
</head>
<body class="TM_body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-navbar">
        <div class="container">
            <div class="navbar-nav">
                <a class="nav-item nav-link <?php echo $params['activeLink'] === "/" ? "active" : "" ?>" href="/">
                    Főoldal
                </a>
                <?php if($params['isAuthorized']  AND $params['isAdmin'] === "1"): ?>
                    <a class="nav-item nav-link <?php echo $params['activeLink'] === "/hero" ? "active" : "" ?>" href="/hero">
                        Kollégák
                    </a>
                <?php endif;?>
                <a class="nav-item nav-link <?php echo $params['activeLink'] === "/csomagok" ? "active" : "" ?>" href="/csomagok">
                    Csomagok
                </a>
                <?php if($params['isAuthorized'] AND $params['isAdmin'] === "1"): ?>
                    <a class="nav-item nav-link <?php echo $params['activeLink'] === "/foglalasok" ? "active" : "" ?>" href="/foglalasok">
                        Foglalások
                    </a>
                <?php endif;?>
                <?php if($params['isAuthorized']): ?>
                    <a class="nav-item nav-link <?php echo $params['activeLink'] === "/sakktabla" ? "active" : "" ?>" href="/sakktabla">
                        Sakktábla
                    </a>
                <?php endif;?>
            </div>
            <?php if($params['isAuthorized']): ?>
                <div class="btn-group">
                    <form action="/profil" method="POST">    
                        <button type="submit" class="btn btn-sm btn-light float-end <?php echo $params['activeLink'] === "/profil" ? "active" : "" ?>">Profil</button>
                    </form>
                    <a class="btn btn-sm btn-light float-end <?php echo $params['activeLink'] === "/profil" ? "active" : "" ?>" href="/chat">
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

        <?php echo $params['innerTemplate'] ?>
    <footer class="bg-dark text-lg-start fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-11 text-center p-3">
                    @Kenyeres Zsolt
                </div>
                <div class="col-md-1 float-end p-3">
                    <a class="nav-item" href="/kapcsolat" style="color:white">Kapcsolat</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>