<p>Kedves <?= $params['name'] ?>!</p>
<p>A(z) <?= $params['accm']['location'] ?> településen található <?= $params['accm']['name'] ?> szálláshelyre elküldött foglalásodat megerősítem.<br>
<p>Alább találod a foglalásod adatait:</p>
<ul>
    <li>Érkezés dátuma: <?= $params['checkin'] ?></li>
    <li>Távozás dátuma: <?= $params['checkout'] ?></li>
    <li>Személyek száma: <?= $params['adults'] . " felnőtt" ?><?= $params['children']>0 ? " és " . $params['children'] . " gyerek" : "" ?></li>
    <li>Éjszakák száma: <?= $params['nights'] ?></li>
    <li>Teljes ár: <?= $params['total_price'] ?> lej</li>
</ul>
<p>Lefoglalt szobák:</p>
<ul>
    <?php foreach($params['unitsDescription'] as $unitDescription): ?>
        <li><?=$unitDescription?></li>
    <?php endforeach;?>
</ul>
<?php if(!empty($params['mealsDescription'])): ?>
    <p>Étkezés:</p>
    <ul>
        <?php foreach($params['mealsDescription'] as $mealDescription): ?>
            <li><?=$mealDescription?></li>
        <?php endforeach;?>
    </ul>
<?php endif; ?>
<?php if(!is_null($params['wellnessDescription']) OR !empty($params['wellnessDescription'])): ?>
    <p>Wellness:</p>
    <ul>
        <li><?=$params['wellnessDescription']?></li>
    </ul>
<?php endif; ?>
<br>
<p>Üdv,<br>Kenyeres Zsolt</p>