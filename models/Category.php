<?php

namespace Model;

class Category extends ActiveRecord {
    protected static $table = 'categories';
    protected static $columnsDB = ['id', 'name'];

    public ?int $id;
    public string $name;
}