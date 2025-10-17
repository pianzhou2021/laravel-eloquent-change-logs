<?php

namespace Pianzhou\EloquentChangeLog\Enums\ChangeLog;

/**
 * Enum representing the type of change log entry.
 */
enum Type: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
    case CUSTOM  = 'custom';
}
