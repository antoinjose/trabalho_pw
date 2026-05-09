

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SAE</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            position: relative;
        }

        /* O formulário agora controla o alinhamento interno */
        form {
            position: absolute;
            right: 70px;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 380px;
            display: flex;
            flex-direction: column; /* Alinha os itens em coluna */
            align-items: center;    /* Centraliza horizontalmente */
            text-align: center;
            box-sizing: border-box;
            position: relative;
        }

        h4 {
            position: absolute;
            right: 622px;
            top: 324px;
            color: #FF0000;
            font-size: 10px;
        }

        h2 {
            font-size: 1.1rem;
            color: #e5e7eb;
            font-weight: 700;
            line-height: 1.2;
            margin-top:-450px;
            margin-left: 105px;
            margin-right: -312px;
        }

        h3 {
            position: absolute;
            top: 210px;
            left: 669px;
            font-size: 0.85rem;
            color: #64748b;
            margin: 0 0 25px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 99;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 15px; /* Espaçamento entre campos */
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            outline: none;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        button {
            width: 100%;
            background-color: #3b82f6;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2563eb;
        }

        /* Anula o efeito visual dos <br> para não quebrar o layout flex */
        br {
            display: none;
        }

        p {
            position: absolute;
            right: 590px;
            margin-top: 34vh;
            font-size: 12px;
            z-index: 99;
        }
        p a {
            text-decoration: none;
            color: #2563eb;
        }

    </style>
</head>
<body>
    <h2>SISTEMA ADMINISTRATIVO EMPRESARIAL</h2>
    <h3>Login</h3>
    <form action="" method='POST'>
        <input type="text" name="email" placeholder="Email"> <br>
        <input type="password" name="senha" placeholder="Senha"><br>
        <button type="submit" name="login" value="Login">Acessar</button><br>
    </form>
    <p>Não possui conta? <a href="cadastrar.php">Cadastre-se</a></p>
</body>
<?php
session_start();


if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $senhapura = $_POST['senha'];
    $hash = password_hash($senhapura, PASSWORD_DEFAULT);



    if(empty($email) || empty($senhapura)) {
        echo "<h4>Por favor, preencha os campos obrigatórios</h4>";
    } else {
        include ('conexao.php');

        $stmt = $conn->prepare("SELECT * FROM dadossae WHERE email = :email LIMIT 1");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch();

        if($email == $usuario['email'] and $senhapura == $usuario['senha']) {

            $_SESSION['usuario_id']    = $usuario['id'];
            $_SESSION['usuario_email']  = $usuario['email'];
            $_SESSION['usuario_senha'] = $usuario['senha'];

            header('Location: restrito.php');
            exit();
        } else {
            echo 'E-mail ou senha inválidos. Tente novamente.';
        }
    }
}

?>
</html>