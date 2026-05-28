<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php
// Garante a conexão com o banco de dados
require_once 'conexao.php';

$empresa_logada = isset($_SESSION['usuario_empresa']) ? $_SESSION['usuario_empresa'] : '';

try {
    
    $stmt = $conn->prepare("SELECT id, nome, cargo, datanasc, dataadmissao FROM funcionarios WHERE empresa = :empresa ORDER BY id DESC");
    $stmt->bindValue(':empresa', $empresa_logada);
    $stmt->execute();
    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $funcionarios = [];
}
?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Quadro de Funcionários</h2>
        <p class="text-xs text-gray-500 mt-1">Gerenciamento de colaboradores registrados na empresa.</p>
    </div>
    <a href="createfun.php" class="bg-sky-500 hover:bg-sky-600 text-white text-xs px-4 py-2.5 rounded font-semibold shadow-sm inline-flex items-center gap-2 transition">
        <i class="fa-solid fa-user-plus text-sm"></i> Novo Funcionário
    </a>
</div>

<div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3.5 font-bold">ID</th>
                <th class="px-6 py-3.5">Nome Completo</th>
                <th class="px-6 py-3.5">Cargo / Função</th>
                <th class="px-6 py-3.5">Data Nasc.</th>
                <th class="px-6 py-3.5">Admissão</th>
                <th class="px-6 py-3.5 text-center">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-gray-700 bg-white">
            <?php if (!empty($funcionarios)): ?>
                <?php foreach ($funcionarios as $func): ?>
                    <tr class="hover:bg-slate-50/80 transition duration-150">
                        <td class="px-6 py-4 font-semibold text-gray-500">#<?= $func['id'] ?></td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                    <?= substr(htmlspecialchars($func['nome']), 0, 2) ?>
                                </div>
                                <span class="font-medium text-gray-900"><?= htmlspecialchars($func['nome']) ?></span>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($func['cargo']) ?></td>
                        
                        <td class="px-6 py-4 text-gray-500">
                            <?= $func['datanasc'] ? date('d/m/Y', strtotime($func['datanasc'])) : '-' ?>
                        </td>
                        
                        <td class="px-6 py-4 text-gray-500">
                            <?= $func['dataadmissao'] ? date('d/m/Y', strtotime($func['dataadmissao'])) : '-' ?>
                        </td>
                        
                        <td class="px-6 py-4 text-center space-x-3 whitespace-nowrap">
                            <a href="modulos/funcionarios/editar.php?id=<?= $func['id'] ?>" class="text-sky-600 hover:text-sky-900 transition" title="Editar">
                                <i class="fa-solid fa-pen-to-square text-base"></i>
                            </a>
                            <a href="modulos/funcionarios/deletar.php?id=<?= $func['id'] ?>" onclick="return confirm('Tem certeza que deseja remover este funcionário?')" class="text-rose-600 hover:text-rose-900 transition" title="Excluir">
                                <i class="fa-solid fa-trash text-base"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-users-slash text-3xl mb-2 block text-gray-300"></i>
                        Nenhum funcionário cadastrado ou encontrado.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>