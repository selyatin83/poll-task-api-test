<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateVoteTable extends AbstractMigration
{
    public const NAME_TABLE = 'vote';

    public function change(): void
    {
        $this->table(self::NAME_TABLE, ['id' => false,'primary_key' => ['user_ip', 'question_id']])
            ->addColumn('user_name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('question_id', 'integer')
            ->addColumn('answer', 'string', ['null' => false])
            ->addColumn('user_ip', 'inet')
            ->addTimestamps()
            ->addForeignKey('question_id', 'question', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}
