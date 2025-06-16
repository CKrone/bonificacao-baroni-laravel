## Sobre o Projeto

O projeto consiste em uma camada de front-end: https://github.com/CKrone/bonificacao-baroni-vue e esta que é a camada de back-end.
Tem como objetivo gerar um excel com o valor médio e a quantidade de venda a partir do relatório de vendas em PDF.
O projeto foi criado por mim a fim de ajudar um colega no preenchimento dos dados. Já está em uso a mais de 1 ano.

## Aprendendo Laravel

Para fins de estudo, resolvi recriar o projeto em Laravel e usando Docker.

## Problema

A empresa possui um sistema para gerar bonificação para o vendedor. Então a colaborador baixava do sistema o relatório de vendas do vendedor específico,
criava-se um excel padrão com todos os produtos listados e nesse excel ia inserindo manualmente os itens vendidos pelo vendedor. Atualmente são mais de 350 produtos.

## Solução

O projeto foi desenvolvido para automatizar o preenchimento de um Excel base com dados de vendas, reduzindo o trabalho manual e minimizando erros.
A aplicação começa com a leitura de um arquivo Excel base, que contém a listagem completa de produtos. 
Essa lista é salva no banco de dados, mas antes disso é feito um backup automático em uma tabela auxiliar para manter a segurança dos dados.
Além disso, o sistema possui uma funcionalidade que lê um PDF de relatório de vendas. Ele extrai apenas as informações relevantes e já realiza os cálculos de negócio necessários.
O front-end então recebe esse retorno, junta com os dados salvos no banco, e começa a montar um novo Excel.
Durante essa montagem, o sistema verifica quais produtos foram vendidos (comparando os dados com o retorno do PDF). Os itens que não aparecem no relatório são preenchidos com valores padrão retirados do banco.
O resultado é um novo Excel, pronto para download, com duas colunas principais: quantidade e valor médio. Ele mantém a mesma estrutura do Excel base, inclusive com linhas em branco para separar os tipos de produtos.
Por fim, o usuário só precisa copiar essas colunas do novo Excel e colar diretamente no arquivo base, que já possui todas as fórmulas e cálculos prontos. Isso agiliza bastante o processo e evita retrabalho.

## Ganhos

A empresa possui 9 vendedores o que levava dias para o preenchimentos de todos, gerando vários erros por conta de preenchimento incorreto.
Atualmente em menos de 2 horas é feito o preenchimento de todos vendedores e conferência.

