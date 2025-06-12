<?php

namespace App\Entity;

enum TaskPriority: string
{
    case LOW = 'Basse';
    case MEDIUM = 'Moyenne';
    case HIGH = 'Haute';
}
