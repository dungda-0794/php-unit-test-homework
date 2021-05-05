<?php

namespace Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class ModelTest extends TestCase
{
    /**
     * @param Model $model
     * @param array $assertions
     *
     * - `fillable` -> `getFillable()`
     * - `guarded` -> `getGuarded()`
     * - `table` -> `getTable()`
     * - `primaryKey` -> `getKeyName()`
     * - `connection` -> `getConnectionName()`: in case multiple connections exist.
     * - `hidden` -> `getHidden()`
     * - `visible` -> `getVisible()`
     * - `casts` -> `getCasts()`: note that method appends incrementing key.
     * - `dates` -> `getDates()`: note that method appends `[static::CREATED_AT, static::UPDATED_AT]`.
     * - `newCollection()`: assert collection is exact type. Use `assertEquals` on `get_class()` result, but not `assertInstanceOf`.
     */
    protected function runConfigurationAssertions(Model $model, $assertions)
    {

        $assertions = array_merge([
            'fillable' => [],
            'hidden' => [],
            'guarded' => ['*'],
            'visible' => [],
            'casts' => ['id' => 'int'],
            'dates' => ['created_at', 'updated_at'],
            'collectionClass' => Collection::class,
            'table' => null,
            'primaryKey' => 'id',
            'connection' => null,
        ], $assertions);
        extract($assertions);
        $this->assertEquals($assertions['fillable'], $model->getFillable());
        $this->assertEquals($assertions['guarded'], $model->getGuarded());
        $this->assertEquals($assertions['hidden'], $model->getHidden());
        $this->assertEquals($assertions['visible'], $model->getVisible());
        $this->assertEquals($assertions['casts'], $model->getCasts());
        $this->assertEquals($assertions['dates'], $model->getDates());
        $this->assertEquals($assertions['primaryKey'], $model->getKeyName());
        $c = $model->newCollection();
        $this->assertEquals($assertions['collectionClass'], get_class($c));
        $this->assertInstanceOf(Collection::class, $c);
        if ($assertions['connection'] !== null) {
            $this->assertEquals($assertions['connection'], $model->getConnectionName());
        }
        if ($assertions['table'] !== null) {
            $this->assertEquals($assertions['table'], $model->getTable());
        }
    }
}
