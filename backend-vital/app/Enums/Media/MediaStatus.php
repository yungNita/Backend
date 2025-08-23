<?php

namespace App\Enums\Media;

enum MediaStatus: string 
{
    case DRAFT = "draft";
    case SCHEDULE = "schedule";
    case PUBLISHED = "published";
    case ARCHIVED = "archived";
}