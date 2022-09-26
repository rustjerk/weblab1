<!doctype html>
<?php

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL ^ E_DEPRECATED);

require "../src/bootstrap.php";

$logEntries = $orm(App\LogEntry::class)
    ->orderBy("creationTime", "desc")
    ->all();

?>
<html>
  <head>
    <title>АРМИЯ РОССИИ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=0">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="styles/main.css">
  </head>
  
  <body>
    <div class="bg"></div>
    
    <img class="mob-hide anime right" src="img/anime1.png">
    <img class="mob-hide anime left" src="img/anime2.png">
    <img class="mob-hide anime center-left" src="img/anime3.gif">
    <img class="mob-hide anime center-right" src="img/anime4.gif">
    <img class="mob-hide anime top-right" src="img/anime5.gif">
    <img class="fly" src="img/fly.gif">

    <table class="container">
      <tr class="header"><td>
        <h1>ZдраVия желаю, тоVарищ майор!</h1>
        <h3>Работу Vыполнил рядоVой P32101 батальона Алексей Никашкин.</h3>
        <h3>За сегодня было денацифицировано 1115 км².</h3>
      </td></tr>

      <tr class="main"><td class="row">
        <div class="side mob-hide">
          <h3>СостаV оператиVной группироVки</h3>
          <ol class="heroes">
            <li>БерестоVский СVятослаV СергееVич <img class="marshal" src="img/marshal.png"></li>
            <li>БухароV Дмитрий ПаVлоVич</li>
            <li>Гасюк Александр АндрееVич</li>
            <li>Гребёнкин Vадим ДмитриеVич</li>
            <li>ГрибоV Михаил ОлегоVич</li>
            <li>ДорофееV Николай ПаVлоVич</li>
            <li>Zенин Мирон АлександроVич</li>
            <li>Калябина Александра НиколаеVна</li>
            <li>Марченко Анна СергееVна</li>
            <li>Никашкин Алексей VалентиноVич</li>
            <li>НуцалханоV Нуцалхан ГасаноVич</li>
            <li>Шульга Артём ИгореVич</li>
          </ol>
        </div>

        <div id="map">
          <h3>Карта боеVых дейстVий</h3>
          <div class="george">
            <img id="plane-proto" class="plane" src="img/plane.png">
            <div id="bomb-proto" class="bomb"></div>
            <div id="playground"></div>
          </div>
          <img class="fly" src="img/fly.gif">
        </div>
      </td></tr>

      <tr class="controls"><td>
        <form action="">
          <div class="row mob-col">
            <fieldset data-radio-container id="coord-x">
              <legend>Координата X</legend>
              <div class="radio-button">
                <input data-radio-button type="button" value="-3">
              </div>
              <div class="radio-button">
                <input data-radio-button type="button" value="-2">
              </div>
              <div class="radio-button">
                <input data-radio-button type="button" value="-1">
              </div>
              <div class="radio-button">
                <input data-radio-button type="button" value="0">
              </div>
              <div class="radio-button selected">
                <input data-radio-button type="button" value="1">
              </div>
              <div class="radio-button">
                <input data-radio-button type="button" value="2">
              </div>
              <div class="radio-button ">
                <input data-radio-button type="button" value="3">
              </div>
              <div class="radio-button">
                <input data-radio-button type="button" value="4">
              </div>
              <div class="radio-button">
                <input data-radio-button type="button" value="5">
              </div>
            </fieldset>

            <fieldset data-radio-container id="radius">
              <legend>Радиус R</legend>
              <label class="checkbox selected">
                <input data-radio-button checked type="checkbox" value="1"><span>1;</span>
                <div class="check"></div>
              </label>
              <label class="checkbox">
                <input data-radio-button type="checkbox" value="1.5"><span>1.5;</span>
                <div class="check"></div>
              </label>
              <label class="checkbox">
                <input data-radio-button type="checkbox" value="2"><span>2;</span>
                <div class="check"></div>
              </label>
              <label class="checkbox">
                <input data-radio-button type="checkbox" value="2.5"><span>2.5;</span>
                <div class="check"></div>
              </label>
              <label class="checkbox">
                <input data-radio-button type="checkbox" value="3"><span>3.</span>
                <div class="check"></div>
              </label>
            </fieldset>
          </div>

          <div class="row mob-col">
            <label class="text-input">
              <div class="row">
                <span>Координата Y</span>
                <span id="coord-y-error" class="error"></span>
              </div>
              <input autocomplete="off" required id="coord-y" type="text" placeholder="(-5...3)">
            </label>
            
            <input type="submit" value="Отправить">
          </div>
        </form>
      </td></tr>

      <tr class="result-container"><td>
        <table class="result">
          <thead>
            <tr>
              <td>Время</td> 
              <td>Затр.</td>
              <td>X</td>
              <td>Y</td>
              <td>R</td>
              <td>Результат</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($logEntries as $entry): ?>
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
            <?php endforeach; ?>
          </tbody>
        </table>
      </td></tr>
    </table>

    <script src="app.js"></script>
  </body>
</html>

