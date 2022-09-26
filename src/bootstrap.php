<?php

require '../vendor/autoload.php';

use Opis\Database\Connection;
use Opis\ORM\EntityManager;

use App\LogEntry;

$connection = new Connection("pgsql:host=pg;dbname=studs", "LOGIN", "PASSWORD");

$orm = new EntityManager($connection);

