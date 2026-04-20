<?php

namespace App\Http\Controllers\API\Docs;

use App\Http\Requests\API\CoupleInviteRequest;

interface CouplesDoc
{
    public function getCoupleRequestsStatus();
    public function inviteCouple(CoupleInviteRequest $request);
    public function acceptCouple();
}

//// user A input ID :
//// user B Melihat Request Dari User A apakah di acc atau tidak