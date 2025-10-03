<?php

namespace Model;

class Hour extends ActiveRecord {
    protected static $table = 'hours';
    protected static $columnsDB = ['id', 'hour'];

    public ?int $id;
    public string $hour;
}