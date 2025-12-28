# 📈 PHP Valuation

Sistema desenvolvido para automatizar o cálculo de **Preço Teto** de ações da B3, unindo minha jornada acadêmica em ADS com o interesse pelo mercado financeiro.

## 🎯 O Problema Resolvido
Investidores de valor precisam mitigar riscos de anos atípicos. O sistema processa a média de dividendos dos últimos 5 anos para aplicar o **Método de Bazin** e utiliza o **Preço Justo de Graham** para sugerir decisões de compra com margem de segurança.

## 🛠 Arquitetura e Diferenciais Técnicos
- **MVC (Model-View-Controller)**: Separação rigorosa de responsabilidades.
- **DTO (Data Transfer Object)**: Implementação de objetos para transporte seguro de dados e tipagem estrita (PHP 8.2+).
- **Router & Autoload**: Sistema de rotas customizado e autoloading via **Composer (PSR-4)**.
- **Segurança**: Uso de variáveis de ambiente (`.env`) e proteção contra SQL Injection via PDO Prepared Statements.

## 📝 Fórmulas Utilizadas
- **Graham**: $\text{Preço Teto} = \sqrt{22.5 \times \text{VPA} \times \text{LPA}}$
- **Bazin**: $\text{Preço Teto} = \frac{\text{Média Dividendos (5 anos)}}{0.06}$
