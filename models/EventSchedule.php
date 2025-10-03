<?php

namespace Model;

class EventSchedule extends ActiveRecord {
    protected static $table = 'events';
    protected static $columnsDB = ['id', 'category_id', 'day_id', 'hour_id'];

    public ?int $id;
    public ?int $category_id;
    public ?int $day_id;
    public ?int $hour_id;
}