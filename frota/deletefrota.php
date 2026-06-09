<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Veículo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f4f6f9] font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-xl border border-gray-200 shadow-xl overflow-hidden p-6 sm:p-8 text-center">
        
        <div class="mb-6 flex justify-center">
            <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center border border-rose-100 shadow-inner text-rose-500 animate-pulse">
                <i class="fa-solid fa-trash-can text-3xl"></i>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Status da Ação</h2>
        
        <div class="text-sm text-gray-600 mt-3 mb-8 bg-slate-50 p-4 rounded-lg border border-gray-100 font-medium">
            <?php
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            include ('../conexao.php');

            $stmt = $conn->prepare("DELETE FROM frota WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            if($stmt->execute()) {
                echo "Veículo excluido com sucesso!";
            }
            ?>
        </div>

        <a href="../restrito.php" class="w-full bg-[#1e293b] hover:bg-[#0f172a] text-white font-semibold text-sm py-3 px-4 rounded-lg shadow-md transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Voltar para o Painel
        </a>

    </div>

</body>
</html>
