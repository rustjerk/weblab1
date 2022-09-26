<?php

$timeStart = microtime(true); 

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL ^ E_DEPRECATED);

require "../src/bootstrap.php";

function isHit($x, $y, $r) {
    if ($x >= 0 && $y >= 0) {
        return $x * $x + $y * $y <= $r * $r; 
    } elseif ($x < 0 && $y >= 0) {
        return $x >= -$r && $y <= $r / 2;
    } elseif ($x >= 0 && $y < 0) {
        return $x <= $y + $r;
    } else {
        return false;
    }
}

function isValid($x, $y, $r) {
    if (!is_numeric($x) || !is_numeric($y) || !is_numeric($r))
        return false;
    if (!in_array($x, array(-3, -2, -1, 0, 1, 2, 3, 4, 5)))
        return false;
    if (!in_array($r, array(1, 1.5, 2, 2.5, 3)))
        return false;
    if ($y <= -5 || $y >= 3)
        return false;
    return true;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw);

if (!isValid($data->x, $data->y, $data->r)) {
    echo "ERROR";
    http_response_code(400);
    return;
}

$timeEnd = microtime(true);

$entry = $orm->create(App\LogEntry::class);
$entry->setCreationTime(new DateTime());
$entry->setDuration($timeEnd - $timeStart);
$entry->setParamX($data->x);
$entry->setParamY($data->y);
$entry->setParamR($data->r);
$entry->setResult(isHit($data->x, $data->y, $data->r));
$orm->save($entry);

?>

<tr>
  <td><?= $entry->creationTime()->setTimeZone(new DateTimeZone("Europe/Moscow"))->format("d/m/Y H:i:s") ?></td> 
  <td><?= round($entry->duration() * 1000) ?> мс</td>
  <td><?= $entry->paramX() ?></td>
  <td><?= $entry->paramY() ?></td>
  <td><?= $entry->paramR() ?></td>
  <?php if ($entry->result()): ?>
    <td><span class="hit"></span>Попал!</td>
  <?php else: ?>
    <td><span class="miss"></span>Промах</td>
  <?php endif; ?>
</tr>

