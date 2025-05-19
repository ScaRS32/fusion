<?php
use Bitrix\Main\Loader;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Grid\Options;
use Bitrix\Main\Context;
use Bitrixdev\Customgrid\Model\CustomEntityTable;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

$APPLICATION->SetTitle("Данные по сделке");

$dealId = (int) $_GET['deal_id'];
$request = Context::getCurrent()->getRequest();

$gridId = 'custom_grid_' . $dealId;
$gridOptions = new Options($gridId);
$sort = $gridOptions->getSorting(['sort' => ['ID' => 'DESC']]);
$nav = $gridOptions->getNavParams();

$filter = ['=DEAL_ID' => $dealId];

// пагинация
$pageNavigation = new \Bitrix\Main\UI\PageNavigation($gridId);
$pageNavigation->allowAllRecords(true)->setPageSize($nav['nPageSize'])->initFromUri();

// выборка
$query = CustomEntityTable::query()
    ->setSelect(['*'])
    ->setFilter($filter)
    ->setOffset($pageNavigation->getOffset())
    ->setLimit($pageNavigation->getLimit())
    ->setOrder($sort['sort']);

$result = $query->exec();
$totalCount = CustomEntityTable::getCount($filter);

$pageNavigation->setRecordCount($totalCount);

$rows = [];
while ($row = $result->fetch()) {
    $rows[] = [
        'data' => $row,
    ];
}

// вывод грида
$APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        'GRID_ID' => $gridId,
        'COLUMNS' => [
            ['id' => 'ID', 'name' => 'ID', 'default' => true],
            ['id' => 'NAME', 'name' => 'Название', 'default' => true],
            ['id' => 'CREATED_AT', 'name' => 'Дата создания', 'default' => true],
        ],
        'ROWS' => $rows,
        'NAV_OBJECT' => $pageNavigation,
        'AJAX_MODE' => 'Y',
        'PAGE_SIZES' => [
            ['NAME' => '10', 'VALUE' => '10'],
            ['NAME' => '20', 'VALUE' => '20'],
            ['NAME' => '50', 'VALUE' => '50'],
        ],
        'SHOW_ROW_CHECKBOXES' => false,
        'SHOW_GRID_SETTINGS_MENU' => true,
        'SHOW_NAVIGATION_PANEL' => true,
        'SHOW_PAGINATION' => true,
        'SHOW_TOTAL_COUNTER' => true,
        'SHOW_PAGESIZE' => true,
        'SHOW_ACTION_PANEL' => false,
        'ALLOW_COLUMNS_SORT' => true,
        'ALLOW_SORT' => true,
        'ALLOW_ROWS_SORT' => false,
        'ALLOW_COLUMNS_RESIZE' => true,
        'ALLOW_HORIZONTAL_SCROLL' => true,
        'ALLOW_PIN_HEADER' => true,
        'AJAX_OPTION_HISTORY' => 'N',
    ]
);