<?php
session_start();
if (!isset($_SESSION['usuario_email']) && !isset($_SESSION['usuario_senha'])) {
    header('Location: index.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "SAE - Painel"; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f4f6f9] font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-[#1e293b] text-slate-300 flex flex-col justify-between hidden md:flex shrink-0 shadow-lg">
            <div>
                <div class="p-5 flex items-center gap-3 border-b border-slate-700 bg-[#0f172a]">
                    <i class="fa-solid fa-cloud text-sky-400 text-2xl"></i>
                    <span class="font-bold text-white text-sm tracking-wide uppercase truncate"><?php echo 'SAE Sistema'; ?></span>
                </div>

                <nav class="mt-6 px-2 space-y-1 text-sm">
                    <button onclick="mudarAba('aba-funcionarios', document.getElementById('btn-nav-funcionarios'))" id="btn-nav-funcionarios" class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded transition text-left group">
                        <i class="fa-solid fa-user-tie text-slate-400 group-hover:text-sky-400 w-5"></i> Funcionários
                    </button>
                    <button onclick="mudarAba('aba-frota', document.getElementById('btn-nav-frota'))" id="btn-nav-frota" class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded transition text-left group">
                        <i class="fa-solid fa-truck-ramp-box text-slate-400 group-hover:text-sky-400 w-5"></i> Frota
                    </button>
                    <button onclick="mudarAba('aba-gestao', document.getElementById('btn-nav-gestao'))" id="btn-nav-gestao" class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded transition text-left group">
                        <i class="fa-solid fa-chart-line text-slate-400 group-hover:text-sky-400 w-5"></i> Gestão
                    </button>
                </nav>
            </div>
            <div class="p-4 border-t border-slate-700 text-xs text-slate-500 bg-[#0f172a] truncate">
                <?php echo $_SESSION['usuario_empresa'], '<p>&copy;2026 SAE. Todos os direitos reservados.</p>'; ?>
            </div>
            <a href="logout.php" onclick="return confirm('Deseja realmente sair do sistema?')" class="w-full flex items-center gap-3 px-3 py-2 text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 rounded font-medium transition text-sm">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Sair do Sistema
            </a>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <header class="bg-white h-16 border-b border-gray-200 px-6 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-4">
                    <button class="text-gray-500 hover:text-gray-700 md:hidden"><i class="fa-solid fa-bars text-xl"></i></button>
                    <div class="flex flex-col text-left">
                        <h2 class="text-sm font-bold text-gray-800 leading-tight">Olá, <?php echo $_SESSION['usuario_nome']; ?></h2>
                        <h4 class="text-[11px] text-gray-500 font-medium tracking-wide uppercase"><?php echo $_SESSION['usuario_empresa']; ?></h4>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs uppercase">
                        <?php echo substr($_SESSION['usuario_nome'], 0, 2); ?>
                    </div>
                    <i class="fa-solid fa-bell text-gray-600 text-xl cursor-pointer"></i>
                </div>
            </header>

            <main class="p-6 space-y-6">
                
                <div class="bg-white rounded border border-gray-200 shadow-sm">
                    
                    <div class="flex bg-gray-50 border-b border-gray-200 rounded-t overflow-x-auto">
                        <button onclick="mudarAba('aba-funcionarios', this)" class="btn-aba px-6 py-3.5 text-sm font-semibold border-b-2 <?= $abaAtiva == 'funcionarios' ? 'border-sky-500 text-sky-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-800' ?> focus:outline-none transition-all duration-150">
                            <i class="fa-solid fa-user-tie mr-2"></i> Funcionários
                        </button>
                        <button onclick="mudarAba('aba-frota', this)" class="btn-aba px-6 py-3.5 text-sm font-semibold border-b-2 <?= $abaAtiva == 'frota' ? 'border-sky-500 text-sky-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-800' ?> focus:outline-none transition-all duration-150">
                            <i class="fa-solid fa-truck-ramp-box mr-2"></i> Frota
                        </button>
                        <button onclick="mudarAba('aba-gestao', this)" class="btn-aba px-6 py-3.5 text-sm font-semibold border-b-2 <?= $abaAtiva == 'gestao' ? 'border-sky-500 text-sky-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-800' ?> focus:outline-none transition-all duration-150">
                            <i class="fa-solid fa-chart-line mr-2"></i> Gestão
                        </button>
                    </div>

                    <div class="p-6">
                        
                        <div id="aba-funcionarios" class="conteudo-aba <?= $abaAtiva == 'funcionarios' ? 'block' : 'hidden' ?>">
                            <?php include('funcionarios/listarfun.php'); ?>
                        </div>

                        <div id="aba-frota" class="conteudo-aba <?= $abaAtiva == 'frota' ? 'block' : 'hidden' ?>">
                            <?php include('frota/listarfrota.php'); ?>
                        </div>

                        <div id="aba-gestao" class="conteudo-aba <?= $abaAtiva == 'gestao' ? 'block' : 'hidden' ?>">
                            <?php include('gestao/listargestao.php'); ?>
                        </div>

                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        function mudarAba(idAba, botaoAtivo) {
            document.querySelectorAll('.conteudo-aba').forEach(c => { c.classList.remove('block'); c.classList.add('hidden'); });
            document.getElementById(idAba).classList.remove('hidden');
            document.getElementById(idAba).classList.add('block');

            document.querySelectorAll('.btn-aba').forEach(b => {
                b.classList.remove('border-sky-500', 'text-sky-600', 'bg-white');
                b.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-800');
            });

            if(botaoAtivo.classList.contains('btn-aba')) {
                botaoAtivo.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-800');
                botaoAtivo.classList.add('border-sky-500', 'text-sky-600', 'bg-white');
            }
        }
    </script>
</body>
</html>

