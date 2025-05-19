<?php
namespace Bitrixdev\Customgrid\Model;

use Bitrix\Main\Entity;

class CustomEntityTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_custom_entity';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', ['primary' => true, 'autocomplete' => true]),
            new Entity\IntegerField('DEAL_ID'),
            new Entity\StringField('NAME'),
            new Entity\DatetimeField('CREATED_AT', ['default_value' => new \Bitrix\Main\Type\DateTime()]),
        ];
    }
}
