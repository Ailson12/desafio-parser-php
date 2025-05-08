<?php

namespace App\Domain\Enum;

enum ProductStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case TRASH = 'trash';
}
