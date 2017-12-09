# DB1_Test

Este projeto é o resultado das tarefas que consegui realizar no tempo disponível. 

Não consegui finalizar tudo, dediquei muito tempo aprendendo a utilizar o Symfony, lendo documentação, adicionando dependências, configurando IDE, etc.

O arquivo referencias.txt contém uma série de links e comandos que me foram úteis dureante o aprendizado.

- Para rodar os testes unitários e preparar a massa de dados para executar a inclusão de um pedido:
1) php bin/console doctrine:fixtures:load
2) vendor\bin\phpunit

Ações disponíveis (routes):
- Incluir Produto: http://localhost:8000/produto/add
- Editar Produto: http://localhost:8000/produto/edit/{id}
- Ver Produto: http://localhost:8000/produto/view/{id}
- Excluir Produto: http://localhost:8000/produto/delete/{id}

- Incluir Pessoa: http://localhost:8000/pessoa/add
- Editar Pessoa: http://localhost:8000/pessoa/edit/{id}
- Ver Pessoa: http://localhost:8000/pessoa/view/{id}
- Excluir Pessoa: http://localhost:8000/pessoa/delete/{id}

Incompleta:
http://localhost:8000/pedido/add

Ainda não implementei a pesquisa.
