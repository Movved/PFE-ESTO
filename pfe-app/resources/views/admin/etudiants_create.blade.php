<!DOCTYPE html>
<html lang="fr">
<head>
    <script>if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }</script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Ajouter Étudiant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
        .page-title { font-size:20px; font-weight:600; color:var(--text-primary); }
        .page-sub { font-size:13px; color:var(--text-secondary); margin-top:2px; }
        .card { background:var(--surface); border:1px solid var(--border); border-radius:12px; overflow:hidden; max-width:640px; }
        .card-header { padding:16px 20px; border-bottom:1px solid var(--border); }
        .card-title { font-size:14px; font-weight:600; color:var(--text-primary); }
        .card-body { padding:20px; display:flex; flex-direction:column; gap:16px; }
        .form-group { display:flex; flex-direction:column; gap:6px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        label { font-size:12px; font-weight:500; color:var(--text-secondary); }
        input[type=text], input[type=email], input[type=password] {
            padding:9px 12px; border:1px solid var(--border); border-radius:8px;
            font-size:13px; background:var(--background); color:var(--text-primary);
            outline:none; width:100%; box-sizing:border-box;
        }
        input:focus { border-color:var(--primary); }
        .form-error { font-size:11px; color:var(--danger); margin-top:2px; }
        .checkbox-row { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-primary); }
        .card-footer { padding:16px 20px; border-top:1px solid var(--border); display:flex; gap:10px; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:opacity 0.15s; }
        .btn:hover { opacity:0.85; }
        .btn-primary { background:var(--primary); color:white; }
        .btn-ghost { background:var(--background); color:var(--text-primary); border:1px solid var(--border); }
    </style>
</head>
<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-admin')

<div class="main">
    <header class="topbar">
        <span class="topbar-title">Ajouter un étudiant</span>
    </header>
    <main class="content">
        <div class="page-header">
            <div>
                <div class="page-title">Nouvel étudiant</div>
                <div class="page-sub">Créer un nouveau compte étudiant</div>
            </div>
            <a href="{{ route('admin.etudiants') }}" class="btn btn-ghost">← Retour</a>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-title">Informations du compte</div></div>
            <form method="POST" action="{{ route('admin.etudiants.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Mohammed">
                            @error('prenom')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Bellatrach">
                            @error('nom')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="m.bellatrach@ump.ac.ma">
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>CNE</label>
                        <input type="text" name="cne" value="{{ old('cne') }}" placeholder="G110023001">
                        @error('cne')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="mot_de_passe" placeholder="••••••••">
                        @error('mot_de_passe')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Créer l'étudiant</button>
                    <a href="{{ route('admin.etudiants') }}" class="btn btn-ghost">Annuler</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
