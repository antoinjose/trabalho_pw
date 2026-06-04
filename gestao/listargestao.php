<?php

require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$empresa_logada = isset($_SESSION['usuario_empresa']) ? $_SESSION['usuario_empresa'] : '';

try {
   
    $stmt = $conn->prepare("SELECT id, titulo, tipo, data_registro, valor, status FROM gestao WHERE empresa = :empresa ORDER BY id DESC");
    $stmt->bindValue(':empresa', $empresa_logada);
    $stmt->execute();
    $relatorios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $relatorios = [
        ['id' => 1, 'titulo' => 'Fechamento Mensal - Abril', 'tipo' => 'Financeiro', 'data_registro' => '2026-04-30', 'valor' => 45250.00, 'status' => 'Concluído'],
        ['id' => 2, 'titulo' => 'Auditoria de Combustível da Frota', 'tipo' => 'Operacional', 'data_registro' => '2026-05-15', 'valor' => 12400.15, 'status' => 'Concluído'],
        ['id' => 3, 'titulo' => 'Previsão de Encargos Trabalhistas', 'tipo' => 'Recursos Humanos', 'data_registro' => '2026-05-28', 'valor' => 8500.00, 'status' => 'Em Análise']
    ];
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-slate-50 border border-gray-200 p-4 rounded-xl flex items-center justify-between shadow-sm">
        <div>
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Faturamento Global</span>
            <span class="text-xl font-black text-gray-800 mt-1 block">R$ 65.120,00</span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-arrow-trend-up text-lg"></i></div>
    </div>
    <div class="bg-slate-50 border border-gray-200 p-4 rounded-xl flex items-center justify-between shadow-sm">
        <div>
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Despesas Operacionais</span>
            <span class="text-xl font-black text-gray-800 mt-1 block">R$ 21.350,15</span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center"><i class="fa-solid fa-arrow-trend-down text-lg"></i></div>
    </div>
    <div class="bg-slate-50 border border-gray-200 p-4 rounded-xl flex items-center justify-between shadow-sm">
        <div>
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Balanço Líquido</span>
            <span class="text-xl font-black text-sky-600 mt-1 block">R$ 43.769,85</span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center"><i class="fa-solid fa-scale-balanced text-lg"></i></div>
    </div>
    <div class="bg-slate-50 border border-gray-200 p-4 rounded-xl flex items-center justify-between shadow-sm">
        <div>
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Metas da Empresa</span>
            <span class="text-xl font-black text-gray-800 mt-1 block">84.5%</span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center"><i class="fa-solid fa-bullseye text-lg"></i></div>
    </div>
</div>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Relatórios & Auditoria</h2>
        <p class="text-xs text-gray-500 mt-1">Crie balanços, acompanhe fluxos e gerencie a documentação administrativa.</p>
    </div>
    <button onclick="abrirModal('modal-gestao')" class="bg-sky-500 hover:bg-sky-600 text-white text-xs px-4 py-2.5 rounded font-semibold shadow-sm inline-flex items-center gap-2">
        <i class="fa-solid fa-file-circle-plus"></i> Novo Relatório
    </button>
</div>

<div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3.5 font-bold">ID</th>
                <th class="px-6 py-3.5">Título do Documento</th>
                <th class="px-6 py-3.5">Tipo</th>
                <th class="px-6 py-3.5">Data de Emissão</th>
                <th class="px-6 py-3.5">Movimentação (R$)</th>
                <th class="px-6 py-3.5 text-center">Status</th>
                <th class="px-6 py-3.5 text-center">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-gray-700 bg-white">
            <?php if (!empty($relatorios)): ?>
                <?php foreach ($relatorios as $rel): ?>
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <td class="px-6 py-4 font-semibold text-gray-500">#<?= $rel['id'] ?></td>
                        
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-file-invoice text-slate-400"></i>
                                <?= htmlspecialchars($rel['titulo']) ?>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 text-gray-600">
                            <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold uppercase tracking-tight">
                                <?= htmlspecialchars($rel['tipo']) ?>
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                            <?= date('d/m/Y', strtotime($rel['data_registro'])) ?>
                        </td>
                        
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            R$ <?= number_format($rel['valor'], 2, ',', '.') ?>
                        </td>
                        
                        <td class="px-6 py-4 text-center">
                            <?php if (trim(strtolower($rel['status'])) === 'concluído' || trim(strtolower($rel['status'])) === 'concluido'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Concluído
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 mr-1.5"></span> Em Análise
                                </span>
                            <?php endif; ?>
                        </td>
                        
                        <td class="px-6 py-4 text-center space-x-3 whitespace-nowrap text-base">
                            <a href="modulos/gestao/visualizar.php?id=<?= $rel['id'] ?>" class="text-slate-500 hover:text-slate-800 transition" title="Visualizar">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="gestao/updategestao.php?id=<?= $rel['id'] ?>" class="text-sky-600 hover:text-sky-900 transition" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="gestao/deletegestao.php?id=<?= $rel['id'] ?>" onclick="return confirm('Tem certeza que deseja apagar permanentemente este relatório gerencial?')" class="text-rose-600 hover:text-rose-900 transition" title="Excluir">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                        Nenhum relatório gerencial aberto para a sua empresa.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>