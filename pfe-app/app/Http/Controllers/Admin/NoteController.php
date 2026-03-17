<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('NOTE')
            ->join('ETUDIANT',    'ETUDIANT.id_etudiant', '=', 'NOTE.id_etudiant')
            ->join('Utilisateur', 'Utilisateur.id_user',  '=', 'ETUDIANT.id_user')
            ->join('MODULE',     'MODULE.id_module',    '=', 'NOTE.id_module')
            ->select(
                'NOTE.id_note',
                'NOTE.note',
                'NOTE.rattrapage',
                'Utilisateur.nom',
                'Utilisateur.prenom',
                'ETUDIANT.cne',
                'MODULE.nom_module',
                'MODULE.code_module'
            );

        if ($request->filled('module')) {
            $query->where('MODULE.id_module', $request->module);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('Utilisateur.nom', 'like', $search)
                  ->orWhere('Utilisateur.prenom', 'like', $search)
                  ->orWhere('ETUDIANT.cne', 'like', $search);
            });
        }

        $notes   = $query->orderBy('Utilisateur.nom')->get();
        $modules = DB::table('MODULE')->orderBy('nom_module')->get();

        return view('admin.notes', compact('notes', 'modules'));
    }

    public function edit($id)
    {
        $note = DB::table('NOTE')
            ->join('ETUDIANT',    'ETUDIANT.id_etudiant', '=', 'NOTE.id_etudiant')
            ->join('Utilisateur', 'Utilisateur.id_user',  '=', 'ETUDIANT.id_user')
            ->join('MODULE',     'MODULE.id_module',    '=', 'NOTE.id_module')
            ->where('NOTE.id_note', $id)
            ->select('NOTE.*', 'Utilisateur.nom', 'Utilisateur.prenom', 'MODULE.nom_module', 'MODULE.code_module')
            ->first();

        abort_if(!$note, 404);

        return view('admin.notes_edit', compact('note'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'note'       => 'nullable|numeric|min:0|max:20',
            'rattrapage' => 'nullable|numeric|min:0|max:20',
        ]);

        DB::table('NOTE')->where('id_note', $id)->update([
            'note'       => $request->note,
            'rattrapage' => $request->rattrapage,
        ]);

        DB::table('LOG_ACTION')->insert([
            'action'            => 'UPDATE',
            'table_concernee'   => 'NOTE',
            'id_enregistrement' => $id,
            'date_action'       => now(),
            'id_user'           => auth()->id(),
        ]);

        return redirect()->route('admin.notes')->with('success', 'Note mise à jour.');
    }
}