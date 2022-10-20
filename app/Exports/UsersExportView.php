<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExportView implements FromView
{
    public function view(): View
    {
        return view('table', [
            'users' => User::all()
        ]);
    }
}
