
# Projeto MVC

Projeto de uma aplicação Fullstack com uma API REST integrada, seguindo os tutoriais do canal WDEV de [MVC com PHP](https://www.youtube.com/playlist?list=PL_zkXQGHYosGQwNkMMdhRZgm4GjspTnXs), com o objetivo de estudo de PHP.

## Como Executar o Projeto

Para fazer o deploy desse projeto você precisa ter o Docker e o Composer instalados em sua máquina.

Clone do repositório na máquina
```bash
  git clone https://github.com/Lugh-o/projetoMVC.git
```
Na pasta do projeto, baixe as dependências pelo composer
```bash
    composer update
```
Monte o container do projeto
```bash
  docker compose up
```

O projeto já deve estar no ar, para acessá-lo, acesse o localhost. Caso queira acessar o painel de administração, acesse "localhost/admin/login", o email padrão para o acesso é "admin@admin" e a senha "admin".
## Variáveis de Ambiente

O arquivo .env está presente no repositório pois esse é um projeto apenas com o intuito de aprendizado, portanto não é necessário alterar nenhuma variável de ambiente para que o projeto funcione.


## Documentação da API

Toda a documentação da API foi feita utilizando o Swagger, e você pode acessá-la link a seguir:
https://lugh-o.github.io/projetoMVC/
## Tecnologias utilizadas
### Front End
- ``HTML 5/CSS 3``
- ``Bootstrap 5``
### Back End
- ``PHP 8``
- ``MySQL``
### Outros
- ``Docker``
- ``Swagger``
