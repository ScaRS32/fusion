<?php
AddEventHandler("crm", "onCrmDealDetailTabs", "AddCustomDealTab");

function AddCustomDealTab(&$arResult)
{
    $dealId = (int)$_REQUEST['deal_id'];
    $arResult[] = [
        "id" => "test",
        "name" => "Вкладка",
        "enabled" => true,
        "loader" => [
            "componentData" => [
                "component" => "bitrix:main.include",
                "params" => [
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/bitrix/admin/deal_custom_tab.php?deal_id=" . $dealId,
                ],
            ],
        ],
    ];
}