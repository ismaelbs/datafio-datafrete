<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDistanceTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('datafrete.distance',['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'uuid')
            ->addColumn('origin', 'string', ['limit' => 8])
            ->addColumn('destination', 'string', ['limit' => 8])
            ->addColumn('distance', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('destination_latitude', 'string', ['limit' => 20])
            ->addColumn('destination_longitude', 'string', ['limit' => 20])
            ->addColumn('origin_latitude', 'string', ['limit' => 20])
            ->addColumn('origin_longitude', 'string', ['limit' => 20]);
        $table->create();
    }

    public function down(): void {
        $this->hasTable('datafrete.distance') ? $this->table('datafrete.distance')->drop()->save() : null;
    }
}
