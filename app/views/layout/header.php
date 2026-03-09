<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentController = $_GET['controller'] ?? 'dashboard';

function isActive($controllerName)
{
    global $currentController;
    return $currentController === $controllerName ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Citas Médicas</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root{
            --sidebar-bg:#111827;
            --sidebar-hover:#1f2937;
            --sidebar-active:#2563eb;
            --body-bg:#f3f4f6;
            --card-bg:#ffffff;
            --text:#111827;
            --muted:#6b7280;
            --border:#e5e7eb;
            --primary:#2563eb;
            --success:#16a34a;
            --warning:#f59e0b;
            --danger:#dc2626;
            --info:#0ea5e9;
            --shadow:0 10px 30px rgba(0,0,0,.08);
            --radius:16px;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:var(--body-bg);
            color:var(--text);
        }

        a{
            text-decoration:none;
        }

        .app{
            display:flex;
            min-height:100vh;
        }

        .sidebar{
            width:260px;
            background:linear-gradient(180deg, #0f172a 0%, #111827 100%);
            color:#fff;
            position:fixed;
            top:0;
            left:0;
            bottom:0;
            padding:18px 14px;
            transition:width .25s ease;
            overflow:hidden;
            z-index:1000;
        }

        .sidebar.collapsed{
            width:88px;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px;
            margin-bottom:18px;
            border-radius:14px;
            background:rgba(255,255,255,.05);
        }

        .brand-icon{
            width:44px;
            height:44px;
            min-width:44px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#2563eb;
            font-size:18px;
        }

        .brand-text{
            display:flex;
            flex-direction:column;
            white-space:nowrap;
            transition:opacity .2s ease;
        }

        .brand-text strong{
            font-size:15px;
            line-height:1.1;
        }

        .brand-text span{
            font-size:12px;
            color:#cbd5e1;
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .logout-text{
            opacity:0;
            width:0;
            overflow:hidden;
        }

        .menu-title{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:1px;
            color:#94a3b8;
            margin:18px 10px 8px;
        }

        .nav{
            display:flex;
            flex-direction:column;
            gap:6px;
        }

        .nav-link{
            display:flex;
            align-items:center;
            gap:12px;
            color:#e5e7eb;
            padding:13px 14px;
            border-radius:12px;
            transition:.2s ease;
            white-space:nowrap;
        }

        .nav-link:hover{
            background:rgba(255,255,255,.07);
            transform:translateX(2px);
        }

        .nav-link.active{
            background:var(--sidebar-active);
            color:#fff;
            box-shadow:0 10px 20px rgba(37, 99, 235, .25);
        }

        .nav-link i{
            width:22px;
            text-align:center;
            font-size:16px;
            min-width:22px;
        }

        .sidebar-footer{
            position:absolute;
            left:14px;
            right:14px;
            bottom:18px;
        }

        .logout-link{
            display:flex;
            align-items:center;
            gap:12px;
            padding:13px 14px;
            color:#fff;
            border-radius:12px;
            background:rgba(220, 38, 38, .9);
            transition:.2s ease;
            white-space:nowrap;
        }

        .logout-link:hover{
            background:var(--danger);
        }

        .main{
            margin-left:260px;
            width:calc(100% - 260px);
            transition:margin-left .25s ease, width .25s ease;
            min-height:100vh;
        }

        .main.expanded{
            margin-left:88px;
            width:calc(100% - 88px);
        }

        .topbar{
            height:76px;
            background:#fff;
            border-bottom:1px solid var(--border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 24px;
            position:sticky;
            top:0;
            z-index:900;
        }

        .topbar-left{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .toggle-btn{
            width:42px;
            height:42px;
            border:none;
            border-radius:12px;
            background:#eef2ff;
            color:#1e40af;
            cursor:pointer;
            font-size:16px;
            transition:.2s ease;
        }

        .toggle-btn:hover{
            transform:translateY(-1px);
            background:#dbeafe;
        }

        .page-title{
            font-size:20px;
            font-weight:700;
            margin:0;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .user-box{
            text-align:right;
        }

        .user-box strong{
            display:block;
            font-size:14px;
        }

        .user-box span{
            font-size:12px;
            color:var(--muted);
            text-transform:capitalize;
        }

        .avatar{
            width:42px;
            height:42px;
            border-radius:50%;
            background:#dbeafe;
            color:#1d4ed8;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
        }

        .content{
            padding:28px;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
            gap:20px;
            margin-bottom:28px;
        }

        .card{
            background:var(--card-bg);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            padding:22px;
            border:1px solid #eef2f7;
        }

        .stat-card{
            position:relative;
            overflow:hidden;
        }

        .stat-card::after{
            content:"";
            position:absolute;
            right:-20px;
            top:-20px;
            width:90px;
            height:90px;
            border-radius:50%;
            background:rgba(37,99,235,.08);
        }

        .stat-label{
            color:var(--muted);
            font-size:14px;
            margin-bottom:8px;
        }

        .stat-value{
            font-size:32px;
            font-weight:700;
            margin:0;
        }

        .section-title{
            margin:0 0 16px;
            font-size:22px;
            font-weight:700;
        }

        .table-card,
        .form-card{
            background:#fff;
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            padding:22px;
            border:1px solid #eef2f7;
        }

        .table-header,
        .form-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            margin-bottom:18px;
            flex-wrap:wrap;
        }

        .table-header h2,
        .form-header h2{
            margin:0;
            font-size:22px;
        }

        .toolbar{
            display:flex;
            gap:12px;
            align-items:center;
            flex-wrap:wrap;
            margin-bottom:18px;
        }

        .search-box{
            position:relative;
            min-width:280px;
            flex:1;
            max-width:420px;
        }

        .search-box i{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            color:#9ca3af;
        }

        .search-box input{
            width:100%;
            padding:12px 14px 12px 40px;
            border:1px solid #d1d5db;
            border-radius:12px;
            font-size:14px;
            background:#fff;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 16px;
            border:none;
            border-radius:12px;
            font-size:14px;
            cursor:pointer;
            transition:.2s ease;
            text-decoration:none;
        }

        .btn:hover{
            transform:translateY(-1px);
        }

        .btn-primary{
            background:var(--primary);
            color:#fff;
        }

        .btn-success{
            background:var(--success);
            color:#fff;
        }

        .btn-warning{
            background:var(--warning);
            color:#fff;
        }

        .btn-danger{
            background:var(--danger);
            color:#fff;
        }

        .btn-secondary{
            background:#e5e7eb;
            color:#111827;
        }

        .table-responsive{
            overflow:auto;
            border-radius:14px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:900px;
        }

        thead th{
            background:#f8fafc;
            color:#374151;
            font-size:13px;
            text-transform:uppercase;
            letter-spacing:.5px;
            padding:14px 12px;
            border-bottom:1px solid var(--border);
        }

        tbody td{
            padding:14px 12px;
            border-bottom:1px solid #f1f5f9;
            font-size:14px;
            vertical-align:middle;
        }

        tbody tr:hover{
            background:#fafcff;
        }

        .actions{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .badge{
            display:inline-block;
            padding:7px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
        }

        .badge-pendiente{
            background:#fef3c7;
            color:#92400e;
        }

        .badge-completada{
            background:#dcfce7;
            color:#166534;
        }

        .badge-cancelada{
            background:#fee2e2;
            color:#991b1b;
        }

        .form-grid{
            display:grid;
            grid-template-columns:repeat(2, 1fr);
            gap:18px;
        }

        .form-group{
            display:flex;
            flex-direction:column;
            gap:8px;
        }

        .form-group.full{
            grid-column:1 / -1;
        }

        label{
            font-size:14px;
            font-weight:600;
            color:#374151;
        }

        input,
        select,
        textarea{
            width:100%;
            padding:12px 14px;
            border:1px solid #d1d5db;
            border-radius:12px;
            outline:none;
            font-size:14px;
            transition:border-color .2s ease, box-shadow .2s ease;
            background:#fff;
        }

        input:focus,
        select:focus,
        textarea:focus{
            border-color:#2563eb;
            box-shadow:0 0 0 4px rgba(37,99,235,.1);
        }

        textarea{
            min-height:120px;
            resize:vertical;
        }

        .form-actions{
            margin-top:20px;
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .empty-box{
            background:#fff;
            border:1px dashed #cbd5e1;
            border-radius:16px;
            padding:40px 24px;
            text-align:center;
            color:var(--muted);
        }

        .chart-box{
            margin-top:24px;
            background:#fff;
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            padding:22px;
        }

        .alert{
            display:flex;
            align-items:flex-start;
            gap:12px;
            padding:14px 16px;
            border-radius:14px;
            margin-bottom:18px;
            border:1px solid transparent;
            box-shadow:var(--shadow);
        }

        .alert i{
            margin-top:2px;
        }

        .alert-success{
            background:#ecfdf5;
            border-color:#a7f3d0;
            color:#065f46;
        }

        .alert-error{
            background:#fef2f2;
            border-color:#fecaca;
            color:#991b1b;
        }

        .alert-info{
            background:#eff6ff;
            border-color:#bfdbfe;
            color:#1e3a8a;
        }

        .hidden-row{
            display:none;
        }

        @media (max-width: 992px){
            .sidebar{
                width:88px;
            }

            .sidebar .brand-text,
            .sidebar .menu-text,
            .sidebar .logout-text,
            .menu-title{
                opacity:0;
                width:0;
                overflow:hidden;
            }

            .main{
                margin-left:88px;
                width:calc(100% - 88px);
            }

            .main.expanded{
                margin-left:88px;
                width:calc(100% - 88px);
            }
        }

        @media (max-width: 768px){
            .topbar{
                padding:0 16px;
            }

            .content{
                padding:18px;
            }

            .form-grid{
                grid-template-columns:1fr;
            }

            .user-box{
                display:none;
            }

            .search-box{
                min-width:100%;
                max-width:100%;
            }
        }
    </style>
</head>
<body>

<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <i class="fa-solid fa-hospital"></i>
            </div>
            <div class="brand-text">
                <strong>Citas Médicas</strong>
                <span>Panel administrativo</span>
            </div>
        </div>

        <div class="menu-title">Menú</div>

        <nav class="nav">
            <a class="nav-link <?= isActive('dashboard'); ?>" href="index.php?controller=dashboard&action=index">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a class="nav-link <?= isActive('cita'); ?>" href="index.php?controller=cita&action=index">
                <i class="fa-solid fa-calendar-check"></i>
                <span class="menu-text">Citas</span>
            </a>

            <a class="nav-link <?= isActive('paciente'); ?>" href="index.php?controller=paciente&action=index">
                <i class="fa-solid fa-users"></i>
                <span class="menu-text">Pacientes</span>
            </a>

            <a class="nav-link <?= isActive('medico'); ?>" href="index.php?controller=medico&action=index">
                <i class="fa-solid fa-user-doctor"></i>
                <span class="menu-text">Médicos</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a class="logout-link" href="index.php?controller=auth&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="logout-text">Cerrar sesión</span>
            </a>
        </div>
    </aside>

    <main class="main" id="main">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="toggle-btn" id="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="page-title">
                    <?= ucfirst(htmlspecialchars($currentController)); ?>
                </h1>
            </div>

            <div class="topbar-right">
                <div class="user-box">
                    <strong><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?></strong>
                    <span><?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'rol'); ?></span>
                </div>
                <div class="avatar">
                    <?= strtoupper(substr($_SESSION['usuario_nombre'] ?? 'U', 0, 1)); ?>
                </div>
            </div>
        </header>

        <section class="content">

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <div><?= htmlspecialchars($_SESSION['success']); ?></div>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-xmark"></i>
                <div><?= htmlspecialchars($_SESSION['error']); ?></div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['info'])): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i>
                <div><?= htmlspecialchars($_SESSION['info']); ?></div>
            </div>
            <?php unset($_SESSION['info']); ?>
        <?php endif; ?>