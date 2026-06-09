<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro SAE</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body{
            background-image: url('pngtree-modern-business-office-interior-background-blurred-space-for-corporate-use-contemporary-image_16359815.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
<?php 

$mensagem = "";
$tipoMensagem = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senhaOriginal = $_POST['senha'];

    if(empty($nome) || empty($email) || empty($senhaOriginal)) {

        $mensagem = "Preencha os campos obrigatórios";
        $tipoMensagem = "erro";

    } else {

        include ('conexao.php');

        $senha = password_hash($senhaOriginal, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO dadossae (nome, email, senha) VALUES (:nome,:email,:senha)");
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);

        if($stmt->execute()) {

            $mensagem = "Conta cadastrada com sucesso!";
            $tipoMensagem = "sucesso";

        } else {

            $mensagem = "Erro ao cadastrar usuário";
            $tipoMensagem = "erro";
        }
    }
}

?>

    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>


    <div class="relative z-10 w-full max-w-md px-6 py-6 bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl mx-4">
        <div class="text-center mb-5">
            <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight">
                Sistema Administrativo Empresarial
            </h1>

            <p class="text-gray-200 mt-3">
                Crie sua conta para acessar o sistema
            </p>
        </div>

        <?php if(!empty($mensagem)): ?>

            <div class="mb-4 p-2 text-sm rounded-xl text-center border
                <?= $tipoMensagem == 'sucesso' 
                    ? 'bg-green-500/20 border-green-400 text-green-100' 
                    : 'bg-red-500/20 border-red-400 text-red-100' ?>">
                
                <?= $mensagem ?>

            </div>

        <?php endif; ?>

        <form action="" method="POST" class="space-y-3">

            <div>
                <label class="block text-white mb-2 font-medium">
                    Nome completo
                </label>

                <input 
                    type="text" 
                    name="nome" 
                    placeholder="Digite seu nome"
                    class="w-full px-4 py-2.5 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-white/20 outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
            </div>

            <div>
                <label class="block text-white mb-2 font-medium">
                    Email
                </label>

                <input 
                    type="text" 
                    name="email" 
                    placeholder="Digite seu email"
                    class="w-full px-4 py-2.5 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-white/20 outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
            </div>

            <div>
                <label class="block text-white mb-2 font-medium">
                    Senha
                </label>

                <input 
                    type="password" 
                    name="senha" 
                    placeholder="Crie uma senha"
                    class="w-full px-4 py-2.5 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-white/20 outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg hover:scale-105"
            >
                Cadastrar
            </button>

        </form>

        <p class="text-center text-gray-200 mt-6">
            Já possui conta?
            <a 
                href="index.php" 
                class="text-blue-300 hover:text-blue-400 font-semibold"
            >
                Voltar ao login
            </a>
        </p>

    </div>

</body>
</html>
