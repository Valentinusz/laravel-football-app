<?php

namespace App\Models;

enum EventType: string {
    case GOAL = 'gól';
    case OWN_GOAL = 'öngól';
    case YELLOW_CARD = 'sárga lap';
    case RED_CARD = 'piros lap';
}
