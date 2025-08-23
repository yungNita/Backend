<?php

namespace App\Enums\Media;

enum MediaCategory:string
{
    case ACTIVITY = "activity";
    case GALLERY = "gallery";
    case KNOWLEDGE = "knowledge";
    case ARTICLE = "article";
    case EVENT = "upcommimg_event";
}