<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index()
    {
        $logs = DB::table('LOG_ACTION')
            ->leftJoin('Utilisateur', 'Utilisateur.id_user', '=', 'LOG_ACTION.id_user')
            ->select(
                'LOG_ACTION.*',
                'Utilisateur.nom',
                'Utilisateur.prenom'
            )
            ->orderByDesc('LOG_ACTION.date_action')
            ->paginate(25);

        return view('admin.logs', compact('logs'));
    }
}