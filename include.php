<?php
use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses('dealgrid', [
    'Dealgrid\\Model\\DealNoteTable' => 'lib/Model/DealNoteTable.php',
]);
