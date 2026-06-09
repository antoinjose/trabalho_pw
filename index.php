<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SAE</title>
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
session_start();

$erro = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if(empty($email) || empty($senha)) {

        $erro = "Por favor, preencha os campos obrigatórios";

    } else {

        include ('conexao.php');

        $stmt = $conn->prepare("SELECT * FROM dadossae WHERE email = :email LIMIT 1");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch();

        if($usuario && password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_senha'] = $usuario['senha'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_empresa'] = $usuario['empresa'];

            header('Location: restrito.php');
            exit();

        } else {

            $erro = "E-mail ou senha inválidos. Tente novamente.";
        }
    }
}
?>

    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="relative z-10 w-full max-w-md px-8 py-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl">

        <div class="text-center mb-8">
           <h1 class="text-2xl md:text-3xl font-bold text-white text-center leading-tight">
                Sistema Administrativo Empresarial
            </h1>
            <p class="text-gray-200 mt-2">
                Acesse e administre sua empresa
            </p>
        </div>

        <?php if(!empty($erro)): ?>
            <div class="mb-5 bg-red-500/20 border border-red-400 text-red-100 p-3 rounded-xl text-center">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-5">

            <div>
                <label class="block text-white mb-2 font-medium">
                    Email
                </label>

                <input 
                    type="text" 
                    name="email" 
                    placeholder="Digite seu email"
                    class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-white/20 outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
            </div>

            <div>
                <label class="block text-white mb-2 font-medium">
                    Senha
                </label>

                <input 
                    type="password" 
                    name="senha" 
                    placeholder="Digite sua senha"
                    class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-white/20 outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg hover:scale-105"
            >
                Acessar
            </button>

        </form>

        <p class="text-center text-gray-200 mt-6">
            Não possui conta?
            <a 
                href="cadastrar.php" 
                class="text-blue-300 hover:text-blue-400 font-semibold"
            >
                Cadastre-se
            </a>
        </p>

    </div>

</body>
</html>
