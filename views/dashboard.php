<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valuation por Graham e Bazin</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <div class="container">
        <h2>📊 Calculadora fundamentalista</h2>

        <?php if ($msg = \App\Core\Session::getFlash('error')): ?>
            <div class="alert alert-error"><?= $msg ?></div>
        <?php endif; ?>

        <?php if ($msg = \App\Core\Session::getFlash('success')): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>

        <form action="salvar" method="POST" class="form-stack">
            <input type="text" name="ticker" placeholder="Ticker (Ex: ITUB4)" required>
            <input type="text" name="vpa" placeholder="VPA Atual" required>
            <input type="text" name="lpa" placeholder="LPA Atual" required>

            <div class="dividend-grid">
                <input type="text" name="div1" placeholder="Div. Ano 1" required>
                <input type="text" name="div2" placeholder="Div. Ano 2" required>
                <input type="text" name="div3" placeholder="Div. Ano 3" required>
                <input type="text" name="div4" placeholder="Div. Ano 4" required>
                <input type="text" name="div5" placeholder="Div. Ano 5" required>
            </div>

            <input type="text" name="current_price" placeholder="Preço Atual de Mercado" required>

            <button type="submit" class="btn-primary">Calcular e Analisar</button>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Ativo</th>
                        <th>Preço Atual</th>
                        <th>Graham (Teto)</th>
                        <th>Bazin (Teto)</th>
                        <th>Div. Médio (5a)</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stocks as $s):
                        $status = (new \App\Models\Stock())->getDecision($s['current_price'], $s['graham_price'], $s['bazin_price']);
                        $badgeClass = ($status == 'CARO') ? 'badge-caro' : 'badge-compra';
                    ?>
                        <tr>
                            <td><strong><?= $s['ticker'] ?></strong></td>
                            <td>R$ <?= number_format($s['current_price'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($s['graham_price'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($s['bazin_price'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($s['dividend'], 2, ',', '.') ?></td>
                            <td><span class="badge <?= $badgeClass ?>"><?= $status ?></span></td>
                            <td style="text-align: center;">
                                <a href="deletar?id=<?= $s['id'] ?>"
                                    class="btn-delete"
                                    onclick="return confirm('Deseja realmente excluir este ativo?')"
                                    style="color: var(--danger); text-decoration: none; font-weight: bold;">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>