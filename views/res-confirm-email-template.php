<p>Kedves <?= $params['name'] ?>!</p>
<p>A(z) <?= $params['accm']['location'] ?> településen található <?= $params['accm']['name'] ?> szálláshelyre elküldött foglalásodat megerősítem.<br>
<p>Alább találod a foglalásod adatait:</p>
<ul>
    <li>Érkezés dátuma: <?= $params['checkin'] ?></li>
    <li>Távozás dátuma: <?= $params['checkout'] ?></li>
    <li>Személyek száma: <?= $params['guests'] ?></li>
    <li>Éjszakák száma: <?= $params['nights'] ?></li>
    <li>Ár: <?= $params['total_price'] ?> lej</li>
</ul>
<br>
<p>Üdv,<br>Kenyeres Zsolt</p>