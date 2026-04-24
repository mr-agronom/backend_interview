<?php
use Bitrix\Sale\Location\LocationTable;

function findAllBy(
    array $criteria = [],
    array $orderBy = [],
    int $limit = 10,
    int $offset = 0
): ArrayCollection {
    $items = LocationTable::query()
        ->setFilter(
            [
                'LOGIC' => 'OR',
                array_merge(
                    [
                        'NAME.LANGUAGE_ID' => LANGUAGE_ID,
                        '=TYPE_ID' => self::CITY_TYPE_ID,
                        'PARENTS.TYPE_ID' => self::REGION_TYPE_ID,
                    ],
                    $criteria
                ),
                array_merge(
                    [
                        'NAME.LANGUAGE_ID' => LANGUAGE_ID,
                        '=TYPE_ID' => self::CITY_TYPE_ID,
                        '=DEPTH_LEVEL' => 3,
                        '=PARENTS.TYPE_ID' => self::COUNTRY_TYPE_ID,
                        'PARENTS.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                    ],
                    $criteria
                ),
                array_merge(
                    [
                        'NAME.LANGUAGE_ID' => LANGUAGE_ID,
                        '=TYPE_ID' => self::CITY_TYPE_ID,
                        '=DEPTH_LEVEL' => 4,
                        '=PARENTS.TYPE_ID' => self::CITY_TYPE_ID,
                        'PARENTS.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                    ],
                    $criteria
                ),
            ]
        )
        ->setOrder($orderBy)
        ->setLimit($limit)
        ->setOffset($offset)
        ->setSelect($this->getSelect())
        ->exec()
        ->fetchAll();

    return $items;
}