<?php

declare(strict_types=1);

namespace Zorachka\Infrastructure\Database\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

interface SpecifiesSchema
{
    public static function specifySchema(Schema $schema): void;
}
