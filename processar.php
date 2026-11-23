<?php
// O formulário deve ser enviado pelo método POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido. Envie o formulário usando POST.');
}

// Função para mostrar os dados com segurança no HTML.
function escapar($dado) {
    return htmlspecialchars((string)$dado, ENT_QUOTES, 'UTF-8');
}

// Recebe e normaliza os campos.
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$experiencia = trim($_POST['experiencia'] ?? '');
$turno = trim($_POST['turno'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');
$oficinas = $_POST['oficinas'] ?? [];

$erros = [];

// Listas de valores permitidos.
$experienciasPermitidas = ['iniciante', 'intermediario', 'avancado'];
$turnosPermitidos = ['manha', 'noite'];
$oficinasPermitidas = ['html_css', 'js_dom', 'php_backend'];

if (mb_strlen($nome) < 3) {
    $erros[] = 'O nome deve ter pelo menos 3 caracteres.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'Informe um e-mail válido.';
}

if (!in_array($experiencia, $experienciasPermitidas, true)) {
    $erros[] = 'Selecione um nível de experiência válido.';
}

if (!in_array($turno, $turnosPermitidos, true)) {
    $erros[] = 'Selecione um turno válido.';
}

// Confere se oficinas é uma lista e se contém opções permitidas.
if (!is_array($oficinas)) {
    $erros[] = 'A seleção de oficinas é inválida.';
    $oficinas = [];
} else {
    foreach ($oficinas as $oficina) {
        if (!is_string($oficina) || !in_array($oficina, $oficinasPermitidas, true)) {
            $erros[] = 'Foi enviada uma oficina inválida.';
            break;
        }
    }
}

if (count($oficinas) === 0) {
    $erros[] = 'Selecione pelo menos uma oficina.';
}

if (mb_strlen($mensagem) > 200) {
    $erros[] = 'A mensagem deve ter no máximo 200 caracteres.';
}

// Nomes para exibir de forma amigável.
$nomesExperiencia = [
    'iniciante' => 'Iniciante',
    'intermediario' => 'Intermediário',
    'avancado' => 'Avançado'
];
$nomesTurno = [
    'manha' => 'Manhã',
    'noite' => 'Noite'
];
$nomesOficinas = [
    'html_css' => 'HTML e CSS',
    'js_dom' => 'JavaScript e DOM',
    'php_backend' => 'PHP e Backend'
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultado da inscrição</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topo">
  <h1>Tech Experience 2026</h1>
</header>
<main class="container">
  <section class="card">
    <?php if (!empty($erros)): ?>
      <h2>Não foi possível concluir a inscrição</h2>
      <p>Confira os itens abaixo e tente novamente:</p>
      <ul>
        <?php foreach ($erros as $erro): ?>
          <li><?= escapar($erro) ?></li>
        <?php endforeach; ?>
      </ul>
      <a href="index.html">Voltar ao formulário</a>
    <?php else: ?>
      <h2>Inscrição realizada com sucesso!</h2>
      <p><strong>Nome:</strong> <?= escapar($nome) ?></p>
      <p><strong>E-mail:</strong> <?= escapar($email) ?></p>
      <p><strong>Experiência:</strong> <?= escapar($nomesExperiencia[$experiencia]) ?></p>
      <p><strong>Turno:</strong> <?= escapar($nomesTurno[$turno]) ?></p>
      <p><strong>Oficinas:</strong></p>
      <ul>
        <?php foreach ($oficinas as $oficina): ?>
          <li><?= escapar($nomesOficinas[$oficina]) ?></li>
        <?php endforeach; ?>
      </ul>
      <p><strong>Mensagem:</strong> <?= escapar($mensagem) ?></p>
      <a href="index.html">Voltar ao início</a>
    <?php endif; ?>
  </section>
</main>
</body>
</html>
