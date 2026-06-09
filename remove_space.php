<?php

/**
 * Remove espaços em branco, BOM UTF-8 e linhas vazias
 * de todos os arquivos PHP do projeto.
 */

$diretorio = __DIR__;

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($diretorio)
);

$total = 0;

foreach ($iterator as $arquivo) {

    if (!$arquivo->isFile()) {
        continue;
    }

    if (pathinfo($arquivo->getFilename(), PATHINFO_EXTENSION) !== 'php') {
        continue;
    }

    $caminho = $arquivo->getPathname();

    $conteudo = file_get_contents($caminho);

    if ($conteudo === false) {
        echo "Erro ao ler: $caminho<br>";
        continue;
    }

    // Remove BOM UTF-8
    $conteudo = preg_replace('/^\xEF\xBB\xBF/', '', $conteudo);

    // Remove espaços e linhas vazias antes do início do arquivo
    $conteudo = ltrim($conteudo);

    // Remove espaços e linhas vazias no final
    $conteudo = rtrim($conteudo);

    // Adiciona quebra de linha única no final
    $conteudo .= PHP_EOL;

    file_put_contents($caminho, $conteudo);

    echo "Corrigido: {$caminho}<br>";

    $total++;
}

echo "<hr>";
echo "Total de arquivos corrigidos: {$total}";
