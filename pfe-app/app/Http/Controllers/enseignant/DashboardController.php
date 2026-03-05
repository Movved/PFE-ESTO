<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the teacher dashboard with statistics
     */
    public function index()
    {
        $teacher = Auth::user();
        $teacherId = $teacher->id_user;

        // Get all filieres where teacher teaches
        $filieres = DB::table('Filiere')
            ->join('Annee_Academique', 'Filiere.id_filiere', '=', 'Annee_Academique.id_filiere')
            ->join('Semestre', 'Annee_Academique.id_annee', '=', 'Semestre.id_annee')
            ->join('Module', 'Semestre.id_semestre', '=', 'Module.id_semestre')
            ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
            ->where('Enseignement.id_user', $teacherId)
            ->distinct('Filiere.id_filiere')
            ->count();

        // Get total students across all filieres where teacher teaches
        $totalStudents = DB::table('Etudiant')
            ->whereIn('id_filiere', function($query) use ($teacherId) {
                $query->distinct('Filiere.id_filiere')
                    ->select('Filiere.id_filiere')
                    ->from('Filiere')
                    ->join('Annee_Academique', 'Filiere.id_filiere', '=', 'Annee_Academique.id_filiere')
                    ->join('Semestre', 'Annee_Academique.id_annee', '=', 'Semestre.id_annee')
                    ->join('Module', 'Semestre.id_semestre', '=', 'Module.id_semestre')
                    ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
                    ->where('Enseignement.id_user', $teacherId);
            })
            ->count();

        // Get evaluations count
        $totalEvaluations = DB::table('Evaluation')
            ->whereIn('id_module', function($query) use ($teacherId) {
                $query->select('id_module')
                    ->from('Enseignement')
                    ->where('id_user', $teacherId);
            })
            ->count();

        // Get filiere IDs where this teacher teaches
        $filiereIds = DB::table('Filiere')
            ->join('Annee_Academique', 'Filiere.id_filiere', '=', 'Annee_Academique.id_filiere')
            ->join('Semestre', 'Annee_Academique.id_annee', '=', 'Semestre.id_annee')
            ->join('Module', 'Semestre.id_semestre', '=', 'Module.id_semestre')
            ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
            ->where('Enseignement.id_user', $teacherId)
            ->distinct()
            ->pluck('Filiere.id_filiere');

        // Get student IDs in those filieres
        $studentIds = DB::table('Etudiant')
            ->whereIn('id_filiere', $filiereIds)
            ->pluck('id_user');

        // Get teacher's module IDs
        $moduleIds = DB::table('Enseignement')
            ->where('id_user', $teacherId)
            ->pluck('id_module');

        // Average note_finale per student across teacher's modules
        // Pass = average >= 10, Fail = average < 10
        $studentAverages = DB::table('Note')
            ->join('Evaluation', 'Note.id_evaluation', '=', 'Evaluation.id_evaluation')
            ->whereIn('Note.id_user', $studentIds)
            ->whereIn('Evaluation.id_module', $moduleIds)
            ->groupBy('Note.id_user')
            ->select('Note.id_user', DB::raw('AVG(Note.note_finale) as moyenne'))
            ->get();

        $passCount = $studentAverages->where('moyenne', '>=', 10)->count();
        $failCount = $studentAverages->where('moyenne', '<', 10)->count();

        return view('enseignant.dashboard', [
            'teacher' => $teacher,
            'totalFilieres' => $filieres,
            'totalStudents' => $totalStudents,
            'totalEvaluations' => $totalEvaluations,
            'passCount' => $passCount,
            'failCount' => $failCount,
        ]);
    }

    /**
     * Show student details with grades in teacher's single module
     */
    public function showStudent($filiereId, $studentId)
    {
        $teacher = Auth::user();
        $filiere = Filiere::findOrFail($filiereId);
        $student = Etudiant::with('user')->where('id_user', $studentId)->firstOrFail();

        // find module teacher teaches for this filiere
        $module = DB::table('Module')
            ->join('Semestre', 'Module.id_semestre', '=', 'Semestre.id_semestre')
            ->join('Annee_Academique', 'Semestre.id_annee', '=', 'Annee_Academique.id_annee')
            ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
            ->where('Annee_Academique.id_filiere', $filiereId)
            ->where('Enseignement.id_user', $teacher->id_user)
            ->select('Module.*', 'Semestre.numero as semestre_numero')
            ->first();

        if (!$module) {
            abort(404);
        }

        $evaluations = DB::table('Evaluation')
            ->where('id_module', $module->id_module)
            ->orderBy('date_evaluation')
            ->get();

        $notes = DB::table('Note')
            ->where('id_user', $studentId)
            ->whereIn('id_evaluation', $evaluations->pluck('id_evaluation'))
            ->get()
            ->keyBy('id_evaluation');

        return view('enseignant.student-details', [
            'student' => $student,
            'filiere' => $filiere,
            'module' => $module,
            'evaluations' => $evaluations,
            'notes' => $notes,
            'teacher' => $teacher
        ]);
    }

    /**
     * Show only filieres where the teacher teaches
     */
    public function filieres()
    {
        $teacher = Auth::user();

        // Get filieres where this teacher teaches modules
        $filieres = Filiere::distinct()
            ->join('Annee_Academique', 'Filiere.id_filiere', '=', 'Annee_Academique.id_filiere')
            ->join('Semestre', 'Annee_Academique.id_annee', '=', 'Semestre.id_annee')
            ->join('Module', 'Semestre.id_semestre', '=', 'Module.id_semestre')
            ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
            ->where('Enseignement.id_user', $teacher->id_user)
            ->select('Filiere.*')
            ->with('responsable', 'anneeAcademiques')
            ->get();

        // add student counts for display
        foreach ($filieres as $f) {
            $f->student_count = Etudiant::where('id_filiere', $f->id_filiere)->count();
        }

        return view('enseignant.filieres', [
            'filieres' => $filieres,
            'teacher' => $teacher
        ]);
    }

    /**
     * Show a filière's single module with students and grade table
     */
    public function showFiliere($id)
    {
        $teacher = Auth::user();
        $filiere = Filiere::findOrFail($id);

        // get the one module teacher teaches in this filiere
        $module = DB::table('Module')
            ->join('Semestre', 'Module.id_semestre', '=', 'Semestre.id_semestre')
            ->join('Annee_Academique', 'Semestre.id_annee', '=', 'Annee_Academique.id_annee')
            ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
            ->where('Annee_Academique.id_filiere', $id)
            ->where('Enseignement.id_user', $teacher->id_user)
            ->select('Module.*', 'Semestre.numero as semestre_numero')
            ->first();

        if (!$module) {
            abort(404, 'Aucun module trouvé pour cette filière');
        }

        // get evaluations and notes for this module
        $evaluations = DB::table('Evaluation')
            ->where('id_module', $module->id_module)
            ->orderBy('date_evaluation')
            ->get();

        $students = Etudiant::where('id_filiere', $id)
            ->with('user')
            ->get();

        $notes = DB::table('Note')
            ->whereIn('id_user', $students->pluck('id_user'))
            ->whereIn('id_evaluation', $evaluations->pluck('id_evaluation'))
            ->get()
            ->groupBy('id_user');

        return view('enseignant.filiere-module', [
            'filiere' => $filiere,
            'module' => $module,
            'evaluations' => $evaluations,
            'students' => $students,
            'notes' => $notes,
            'teacher' => $teacher
        ]);
    }

    /**
     * Update student grade
     */
    public function updateGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'evaluation_id' => 'required|integer',
            'note' => 'required|numeric|min:0|max:20',
            'rattrapage' => 'nullable|numeric|min:0|max:20',
        ]);

        $teacher = Auth::user();

        // Verify that the evaluation is for a module the teacher teaches
        $evaluation = DB::table('Evaluation')
            ->join('Module', 'Evaluation.id_module', '=', 'Module.id_module')
            ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
            ->where('Evaluation.id_evaluation', $request->evaluation_id)
            ->where('Enseignement.id_user', $teacher->id_user)
            ->first();

        if (!$evaluation) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
            }
            return back()->with('error', 'Unauthorized: You cannot update this grade.');
        }

        // Calculate final note (higher of note and rattrapage)
        $noteFinal = $request->rattrapage ? max($request->note, $request->rattrapage) : $request->note;

        // Check if note exists
        $noteExists = DB::table('Note')
            ->where('id_user', $request->student_id)
            ->where('id_evaluation', $request->evaluation_id)
            ->exists();

        if ($noteExists) {
            DB::table('Note')
                ->where('id_user', $request->student_id)
                ->where('id_evaluation', $request->evaluation_id)
                ->update([
                    'note' => $request->note,
                    'rattrapage' => $request->rattrapage,
                    'note_finale' => $noteFinal,
                ]);
        } else {
            DB::table('Note')->insert([
                'id_user' => $request->student_id,
                'id_evaluation' => $request->evaluation_id,
                'note' => $request->note,
                'rattrapage' => $request->rattrapage,
                'note_finale' => $noteFinal,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Note mise à jour avec succès!']);
        }
        return back()->with('success', 'Note mise à jour avec succès!');
    }

    /**
     * Update multiple student grades at once
     */
    public function updateGrades(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'notes' => 'required|array',
            'notes.*.note' => 'required|numeric|min:0|max:20',
            'notes.*.rattrapage' => 'nullable|numeric|min:0|max:20',
        ]);

        $teacher = Auth::user();

        // Verify that all evaluations are for modules the teacher teaches
        foreach ($request->notes as $evaluationId => $noteData) {
            $evaluation = DB::table('Evaluation')
                ->join('Module', 'Evaluation.id_module', '=', 'Module.id_module')
                ->join('Enseignement', 'Module.id_module', '=', 'Enseignement.id_module')
                ->where('Evaluation.id_evaluation', $evaluationId)
                ->where('Enseignement.id_user', $teacher->id_user)
                ->first();

            if (!$evaluation) {
                return back()->with('error', 'Unauthorized: You cannot update grades for some evaluations.');
            }
        }

        // Process each note
        foreach ($request->notes as $evaluationId => $noteData) {
            $noteFinal = isset($noteData['rattrapage']) && $noteData['rattrapage'] !== '' ?
                        max($noteData['note'], $noteData['rattrapage']) : $noteData['note'];

            $noteExists = DB::table('Note')
                ->where('id_user', $request->student_id)
                ->where('id_evaluation', $evaluationId)
                ->exists();

            if ($noteExists) {
                DB::table('Note')
                    ->where('id_user', $request->student_id)
                    ->where('id_evaluation', $evaluationId)
                    ->update([
                        'note' => $noteData['note'],
                        'rattrapage' => $noteData['rattrapage'] ?? null,
                        'note_finale' => $noteFinal,
                    ]);
            } else {
                DB::table('Note')->insert([
                    'id_user' => $request->student_id,
                    'id_evaluation' => $evaluationId,
                    'note' => $noteData['note'],
                    'rattrapage' => $noteData['rattrapage'] ?? null,
                    'note_finale' => $noteFinal,
                ]);
            }
        }

        return back()->with('success', 'Toutes les notes ont été mises à jour avec succès!');
    }
}