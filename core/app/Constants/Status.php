<?php

namespace App\Constants;

class Status{

    const ENABLE = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO = 0;

    const VERIFIED = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS = 1;
    const PAYMENT_PENDING = 2;
    const PAYMENT_REJECT = 3;

    CONST TICKET_OPEN = 0;
    CONST TICKET_ANSWER = 1;
    CONST TICKET_REPLY = 2;
    CONST TICKET_CLOSE = 3;

    CONST PRIORITY_LOW = 1;
    CONST PRIORITY_MEDIUM = 2;
    CONST PRIORITY_HIGH = 3;

    const USER_ACTIVE = 1;
    const USER_BAN = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING = 2;
    const KYC_VERIFIED = 1;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM = 3;

    
    const PENDING   = 0;
    const PUBLISHED = 1;
    const REJECTED  = 2;

    const CAMPAIGN_APPROVED  = 1;
    const CAMPAIGN_REJECTED  = 2;

    const DONATION_PAID   = 1;
    const DONATION_UNPAID = 0;

    const UNPUBLISH = 0;

    const VOLUNTEER_ACTIVE   = 1;
    const VOLUNTEER_INACTIVE = 0;

    const GOAL_ACHIEVE = 1;
    const AFTER_DEADLINE = 2;
    const CONTINUOUS = 3;

}
