<?php

namespace App\Http\Controllers\settings;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingReportExpirationController extends Controller
{
    public function index()
    {
        // Get the current date
        $currentDate = Carbon::now();

        $users = User::whereNotNull('visa_expiry_date')
            ->whereNotNull('permit_expiry_date')
            ->where(function ($query) use ($currentDate) {
                $query->whereDate('visa_expiry_date', '<', $currentDate)
                    ->orWhereDate('permit_expiry_date', '<', $currentDate);
            })
            ->paginate(20);

        return view('dashboard.report.expiration.index', [
            'users' => $users
        ]);
    }

    public function search(Request $request)
    {
        $numOfMonth = $request->searchQuery;
        $currentDate = Carbon::now();

        $users = User::whereNotNull('visa_expiry_date')
            ->whereNotNull('permit_expiry_date')
            ->where(function ($query) use ($currentDate, $numOfMonth) {
                $query->whereDate('visa_expiry_date', '<', $currentDate->addMonths($numOfMonth))
                    ->orWhereDate('permit_expiry_date', '<', $currentDate->addMonths($numOfMonth));
            })
            ->paginate(20);

        return view('dashboard.report.expiration.table-render.expiration-table',['users' => $users])->render();
    }
}
