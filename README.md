# DB1_Test

Este projeto é o resultado das tarefas que consegui realizar no tempo disponível. 

Não consegui finalizar tudo, dediquei muito tempo aprendendo a utilizar o Symfony, lendo documentação, adicionando dependências, configurando IDE, etc.

O arquivo referencias.txt contém uma série de links e comandos que me foram úteis dureante o aprendizado.

- Para rodar os testes unitários e preparar a massa de dados para executar a inclusão de um pedido:
1) php bin/console doctrine:fixtures:load
2) vendor\bin\phpunit

- Para abrir a home:
1) server:run
2) http://localhost:8000/

- Para abrir a página (incompleta) de inclusão de pedido:
1) server:run
2) http://localhost:8000/pedido/add
