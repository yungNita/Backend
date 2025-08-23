<?php

namespace App\Enums\Media;

enum MediaStatus:string 
{
    case DRAFF = "draft";
    case SCHEDULE = "schedule";
    case PUBLISHED = "published";
    case ARCHIVED = "archived";
}