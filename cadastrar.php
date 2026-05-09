<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro SAE</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
            position: relative;
        }

        /* Card de Cadastro */
        form {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            /* Estilização para o texto puro (labels) dentro do form */
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: left;
            margin-right: 480px;
            position: relative;
        }

        h4 {
            position: absolute;
            right: 582px;
            top: 390px;
            color: #FF0000;
            font-size: 10px;
        }

        .sucesso  {
            position: absolute;
            right: 691px;
            top: 390px;
            color: #00FF00;
            font-size: 10px;
        }

        a {
            position: absolute;
            right: 638px;
            top: 485px;
            color: #1e293b;
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
        }

        h2 {
            margin-top: -450px;
            font-size: 1.4rem;
            color: #e5e7eb;
            font-weight: 700;
            text-align: center; /* Título continua centralizado */
            width: 100%;
            margin-left: 480px;
            margin-right: -412px;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            margin: 8px 0 20px 0; /* Espaço após o input */
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            outline: none;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        button {
            width: 100%;
            background-color: #3b82f6;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2563eb;
        }

        /* Remove visualmente os <br> para controle total via CSS */
        br {
            display: none;
        }
    </style>
</head>
<body>
    <h2>Cadastro de Conta</h2>
    <form action="" method='POST'>
        Nome completo: <br>
        <input type="text" name="nome" placeholder="Nome(nome completo)">
        <br>
        Email:
        <br>
        <input type="text" name="email" placeholder="Email">
        <br>
        Crie uma senha:
        <br>
        <input type="password" name="senha" placeholder="senha(4 dígitos)">
        <br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    if(empty($nome) || empty($email) || empty($senha)) {
        echo "<h4>Por favor, preencha os campos para efetuar o cadastro</h4>";
    } else {
        include ('conexao.php');

        $stmt = $conn->prepare("INSERT INTO dadossae (nome, email, senha) VALUES (:nome,:email,:senha)");
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);

        if($stmt->execute()) {
            echo "<h4 class='sucesso'>Conta cadastrada com sucesso!</h4>";
            echo "<a href='index.php'>Voltar ao login</a>";
        } else {
            echo "Erro ao cadastrar usuário";
        }

        
    }
}





?>
</html>