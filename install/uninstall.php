<?php
global $DB;
$DB->RunSQLBatch(__DIR__ . '/db/uninstall.sql');
