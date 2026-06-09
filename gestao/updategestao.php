<?php
session_start();
if (!isset($_SESSION['usuario_email']) && !isset($_SESSION['usuario_senha'])) {
    header('Location: ../index.php');
    exit();
}
$erro = "";
$sucesso = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $tipo = trim($_POST['tipo']);
    $valor = trim($_POST['valor']);
    $status = trim($_POST['status']);
    $data_registro = date('Y-m-d');

    if (empty($titulo) || empty($tipo) || empty($status)) {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        try {
            include('../conexao.php');

            $stmt = $conn->prepare("UPDATE gestao SET titulo=:titulo, tipo=:tipo, valor=:valor, status=:status WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':titulo', $titulo);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->bindValue(':valor', !empty($valor) ? str_replace(',', '.', $valor) : 0);
            $stmt->bindValue(':status', $status);

            if ($stmt->execute()) {
                $sucesso = "Relatório administrativo atualizado com sucesso!";
                $titulo = $tipo = $valor = $status = ""; 
            } else {
                $erro = "Erro ao salvar os dados no banco de dados.";
            }
        } catch (Exception $e) {
            $erro = "Erro de conexão: " . $e->getMessage();
        }
    }
}
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização Relatório de Gestão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f4f6f9] font-sans antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-2xl bg-white rounded-xl border border-gray-200 shadow-xl overflow-hidden">
        
        <div class="bg-[#1e293b] p-6 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-sky-500 rounded-lg flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-file-circle-plus text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-wide">Atualizar Relatório / Balanço</h2>
                    <p class="text-xs text-slate-400">Atualize os dados administrativos para auditoria interna</p>
                </div>
            </div>
            <a href="../restrito.php" class="text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-3 py-2 rounded-lg flex items-center gap-2 transition">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
            </a>
        </div>

        <form action="" method="POST" class="p-6 sm:p-8 space-y-6">
            
            <?php if (!empty($erro)): ?>
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-triangle-exclamation text-base shrink-0"></i>
                    <span><?= $erro; ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($sucesso)): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg flex items-center justify-between gap-3 text-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-base shrink-0"></i>
                        <span><?= $sucesso; ?></span>
                    </div>
                    <a href="../../index.php?aba=gestao" class="underline font-semibold hover:text-emerald-900 transition">Ver central &rarr;</a>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Título do Documento / Relatório <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="titulo" placeholder="Ex: Fechamento de Caixa Mensal ou Auditoria Interna" value="<?= isset($titulo) ? htmlspecialchars($titulo) : '' ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                        <i class="fa-solid fa-heading absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Tipo de Auditoria <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="tipo" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition appearance-none cursor-pointer">
                            <option value="">Selecione uma opção...</option>
                            <option value="Financeiro" <?= isset($tipo) && $tipo == 'Financeiro' ? 'selected' : '' ?>>Financeiro</option>
                            <option value="Operacional" <?= isset($tipo) && $tipo == 'Operacional' ? 'selected' : '' ?>>Operacional</option>
                            <option value="Recursos Humanos" <?= isset($tipo) && $tipo == 'Recursos Humanos' ? 'selected' : '' ?>>Recursos Humanos</option>
                            <option value="Logística" <?= isset($tipo) && $tipo == 'Logística' ? 'selected' : '' ?>>Logística</option>
                        </select>
                        <i class="fa-solid fa-boxes-stacked absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-4 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Movimentação Financeira (R$)
                    </label>
                    <div class="relative">
                        <input type="text" name="valor" placeholder="0.00" value="<?= isset($valor) ? htmlspecialchars($valor) : '' ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                        <i class="fa-solid fa-dollar-sign absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Status do Documento <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-4 mt-1">
                        <label class="flex items-center gap-2 bg-gray-50 border border-gray-200 px-4 py-3 rounded-lg cursor-pointer hover:bg-slate-50 transition text-sm font-medium text-gray-700">
                            <input type="radio" name="status" value="Em Análise" class="text-sky-500 focus:ring-sky-500" <?= !isset($status) || $status == 'Em Análise' ? 'checked' : '' ?>>
                            <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span> Em Análise
                        </label>
                        <label class="flex items-center gap-2 bg-gray-50 border border-gray-200 px-4 py-3 rounded-lg cursor-pointer hover:bg-slate-50 transition text-sm font-medium text-gray-700">
                            <input type="radio" name="status" value="Concluído" class="text-sky-500 focus:ring-sky-500" <?= isset($status) && $status == 'Concluído' ? 'checked' : '' ?>>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Concluído
                        </label>
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="../../index.php?aba=gestao" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie"></i> Atualizar Relatório
                </button>
            </div>

        </form>
    </div>

</body>
</html>