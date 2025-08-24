<?php

namespace App\Enums;

enum ApplcationStatus:string 
{
    case UNDER_REVIEW = "under_review";
    case INTERVIEW = "interview";
    case OFFER = "offer";
    case REJECTED = "rejected";
    case ACCEPTED = "accepted";
}
