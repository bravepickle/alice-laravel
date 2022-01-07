<?php

namespace Tests\Models;

use BravePickle\AliceLaravel\Models\GenericModel;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\SQLiteConnection;
use PDO;
use PHPUnit\Framework\TestCase;
use Throwable;

class GenericModelTest extends TestCase
{
    protected const DB_FILE = __DIR__ . DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'database.sqlite';
//
//    protected function setUp(): void
//    {
//        touch(self::DB_FILE);
//    }
//
//    protected function tearDown(): void
//    {
////        if (file_exists(self::DB_FILE)) {
////            unlink(self::DB_FILE);
////        }
//    }

    /**
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::__construct
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::applyContext
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::getCreatedAtColumn
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::getUpdatedAtColumn
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::setCasts
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::setFillable
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::setGuarded
     * @covers \BravePickle\AliceLaravel\Models\GenericModel::setTouches
     * @throws Throwable
     */
    public function testSave(): void
    {
        $pdo = new PDO('sqlite::memory:');
//        $pdo = new \PDO('sqlite:' . self::DB_FILE);

        $pdo->exec('DROP TABLE IF EXISTS products');

        $pdo->exec(
            'CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT, '.
            'name STRING, active INTEGER, date_updated STRING, date_created STRING)'
        );

        $connection = new SQLiteConnection($pdo);

        $resolver = new ConnectionResolver(['default' => $connection]);
        $resolver->setDefaultConnection('default');

        GenericModel::setConnectionResolver($resolver);
        $model = new GenericModel(
            [],
            [
                'table' => 'products',
                'connection' => 'default',
                'fillable' => ['name'],
                'guarded' => [],
                'touches' => [],
                'casts' => ['active' => 'bool'],
                'key_name' => 'id',
                'key_type' => 'int',
                'timestamps' => true,
                'incrementing' => true,
                'created_at' => 'date_created',
                'updated_at' => 'date_updated',
            ]
        );
        $model->setAttribute('name', 'test');
        $model->setAttribute('active', '1');

        $model->saveOrFail();

        $this->assertNotEmpty($model->id, 'Identifier not returned');
        $this->assertNotEmpty($model->date_created, 'Created date must be set');
        $this->assertNotEmpty($model->date_updated, 'Updated date must be set');
        $this->assertTrue($model->active, 'Active status must be set');
    }
}
