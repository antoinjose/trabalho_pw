<?php

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $cargo = trim($_POST['cargo']);
    $dn = $_POST['dn'];
    $da = $_POST['da'];

    if (empty($nome) || empty($dn) || empty($da) || empty($cargo)) {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        try {
            session_start();
            include('conexao.php');

            $stmt = $conn->prepare("INSERT INTO funcionarios (nome, cargo, datanasc, dataadmissao, empresa) VALUES (:nome, :cargo, :datanasc, :dataadmissao, :empresa)");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':cargo', $cargo);
            $stmt->bindValue(':datanasc', $dn);
            $stmt->bindValue(':dataadmissao', $da);
            $stmt->bindValue(':empresa', $_SESSION['usuario_empresa']);

            if ($stmt->execute()) {
                $sucesso = "Funcionário cadastrado com sucesso!";
                $nome = $cargo = $dn = $da = ""; 
            } else {
                $erro = "Erro ao salvar os dados no banco de dados.";
            }
        } catch (Exception $e) {
            $erro = "Erro de conexão: " . $e->getMessage();
        }
    }
}
?>


        <form action="" method="POST" class="p-6 sm:p-8 space-y-6">
            
            <?php if (!empty($erro)): ?>
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-lg flex items-center gap-3 text-sm animate-fade-in">
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
                    <a href="../restrito.php" class="underline font-semibold hover:text-emerald-900 transition">Ver listagem &rarr;</a>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Nome Completo <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nome" placeholder="Ex: João da Silva" value="<?= isset($nome) ? htmlspecialchars($nome) : '' ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                        <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Cargo / Função <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="cargo" placeholder="Ex: Motorista Operacional" value="<?= isset($cargo) ? htmlspecialchars($cargo) : '' ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                        <i class="fa-solid fa-briefcase absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Data de Nascimento <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" name="dn" value="<?= isset($dn) ? $dn : '' ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                        <i class="fa-solid fa-cake-candles absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Data de Admissão <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" name="da" value="<?= isset($da) ? $da : '' ?>" class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                        <i class="fa-solid fa-calendar-check absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end gap-3">
                <a href="../../index.php?aba=funcionarios" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-500 hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Salvar Cadastro
                </button>
            </div>

        </form>