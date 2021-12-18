<p>Kedves <?= $params['name'] ?>!</p>
<p>A(z) <?= $params['package']['location'] ?> településen található <?= $params['package']['name'] ?> szálláshelyre elküldött foglalásodat megerősítem.<br>
<p>Alább találod a foglalásod adatait:</p>
<ul>
    <li>Érkezés dátuma: <?= $params['checkin'] ?></li>
    <li>Távozás dátuma: <?= $params['checkout'] ?></li>
    <li>Személyek száma: <?= $params['guests'] ?></li>
    <li>Éjszakák száma: <?= $params['nights'] ?></li>
    <li>Ár: <?= $params['totalPrice'] ?> lej</li>
</ul>
<br>
<p>Üdv,<br>Kenyeres Zsolt</p>