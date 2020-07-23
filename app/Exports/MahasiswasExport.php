<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\CompetitionCategory;
use App\Mahasiswa;


class MahasiswasExport implements FromView, WithTitle
{
    public function title(): string
    {
        return 'Daftar Peserta';
    }
    public function view(): View
    {
        $participants = CompetitionCategory::with('team')->get();
        $users = Mahasiswa::with('user')->with('team')->with('category')->orderBy('mahasiswa_name')->get();
        return view('exports/participants', [
            'users' => $users,
            'participants' => $participants
        ]);
    }
}
