<?php

namespace App\Constants;

class Status
{

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

    const TICKET_OPEN = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY = 2;
    const TICKET_CLOSE = 3;

    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH = 3;

    const USER_ACTIVE = 1;
    const USER_BAN = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING = 2;
    const KYC_VERIFIED = 1;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM = 3;

    const BOOKING_UNPAID   = 0;
    const BOOKING_PAID     = 1;


    const BOOKING_PENDING  = 0;
    const BOOKING_APPROVED = 1;
    const BOOKING_CANCELED = 2;
    const BOOKING_REFUNDED = 4;
    const BOOKING_EXPIRED  = 6;

    const WORKING_COMPLETED  = 1;
    const WORKING_DELIVERED  = 2;
    const WORKING_INPROGRESS = 3;
    const WORKING_EXPIRED    = 4;
    const WORKING_DISPUTED   = 5;


    const JOB_EXPIRED   = 6;

    const PENDING    = 0;
    const APPROVED   = 1;
    const CANCELED   = 2;
    const CLOSED     = 3;
    const REJECTED   = 6;


    const FIXED      = 1;
    const PERCENTAGE = 2;

    const SOFTWARE_ORDER_DETAILS_COUNT = 6;
    const SERVICE_ORDER_DETAILS_COUNT = 10;
}
