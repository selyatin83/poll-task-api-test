<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateQuestionTable extends AbstractMigration
{
    public const NAME_TABLE = 'question';

    public function change(): void
    {
        $this->table(self::NAME_TABLE)
            ->addColumn('question', 'string', ['limit' => 5000])
            ->addColumn('answers', 'jsonb', ['null' => false])
            ->addTimestamps()
            ->addIndex('answers', ['type' => 'gin'])
            ->create();
    }
}
