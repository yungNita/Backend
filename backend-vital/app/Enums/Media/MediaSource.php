<?php

namespace App\Enums\Media;

enum MediaSource: string
{
    case FACEBOOK = 'facebook';
    case INSTAGRAM = 'instagram';
    case YOUTUBE = 'youtube';
    case EDUCATION = 'education';
    case CULTURE = 'culture';
    case SOCIETY = 'society';
    case HEALTH = 'health';
    case SPORT = 'sport';
    case ENVIRONMENT = 'environment';
}