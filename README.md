## Sobre o Projeto

Projeto tem como objetivo gerar um excel com o valor médio e a quantidade de venda a partir do relatório de vendas em PDF.
O projeto foi criado por mim a fim de ajudar um colega no preenchimento dos dados. Já está em uso a mais de 1 ano.

## Problema

A empresa possui um sistema para gerar bonificação para o vendedor. Então a colaborador baixava do sistema o relatório de vendas do vendedor específico,
criava-se um excel padrão com todos os produtos listados e nesse excel ia inserindo manualmente os itens vendidos pelo vendedor, atualmente são mais de 300 produtos.

## Solução

Criei uma importação de um arquivo base excel, o arquivo que contém todos os produtos, salvando esses produtos no banco. 
Adicionei a funcionalidade de ler o PDF e buscar todos os dados, aplicando regras de negócio (somatórios e médias de alguns valores).
Ao ler o PDF ele gera um retorno apenas com as informações necessárias, após a leitura do PDF, busco a listagem dos produtos que foram importadas.
Assim seguindo a ordem da listagem (para facilitar o preenchimento), se o produto foi vendido insiro os dados em um novo arquivo excel, caso contrário
utiliza as informações padrões (zeradas) da listagem importada. 
No fim, é gerado um arquivo excel com duas colunas conténdo a quantidade e o valor médio. Como a planilha excel base (que é importada) possui linhas que
separam os tipos de produtos, nesse excel que gero, faço também essa divisão, para o colaborador somente copiar todos valores da coluna e colar na planilha final.

## Ganhos

São mais de 7 vendedores o que levava dias para o preenchimentos de todos, gerando vários erros por conta de preenchimento incorreto.
Atualmente em menos de 2 horas é feito o preenchimento de todos vendedores e conferência.

## Aprendendo Laravel

Para fins de estudo, resolvi recriar o projeto em Laravel e usando Docker.

