# Requisitos para execução

- PHP >= 8.1  
- Composer  
- MySQL
- Laragon, XAMPP, etc.

# Como executar o projeto

* Clone esse repositório e mova a pasta para dentro da pasta do servidor local (caso esteja usando um);
* No terminal dentro da pasta do projeto, escute o seguinte comando, para instalar as dependencias PHP:
```
composer install
```
* Crie um arquivo .env dentro do projeto executando o seguinte comando no terminal: 
```
cp .env.example .env
```
* Dentro do arquivo .env recem criado procure as seguintes linhas:
```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
* E altere para o seguinte:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=PokemonTeams # Ou o nome que preferir
DB_USERNAME=root # Seu nome de usuario do banco
DB_PASSWORD= # Sua senha do banco
```
* Va no seu gerenciador de banco de dados e crie um banco de dados com o mesmo nome do colocado no .env, após isso, no terminal aberto na pasta do projeto execute: 

```
php artisan migrate
```
* Assim serão criadas as tabelas do banco de dados

* e por fim, rode o seguinte comando para executar a aplicação:
```
php artisan serve
```
# Funcionamento
A api tem os seguintes endpoints:
## Autenticação
* `POST : /api/users`: usado para registrar novos usuarios, recebe o seguinte no body da requisição:
```
{
  "name": "lucas",
  "email": "lucas@email.com",
  "password": "123456",
  "password_confirmation": "123456"
}
```
e responde com:
```
{
    (Status code 201)
    "message": "Usuário registrado com sucesso",
    "usuario": {
        "name": "lucas",
        "email": "lucas@email.com",
        "updated_at": "2025-08-04T18:42:25.000000Z",
        "created_at": "2025-08-04T18:42:25.000000Z",
        "id": 1
    }
}
```
* `POST : /api/login`: usado para fazer o login do usuario, recebe o seguinte objeto:
```
{
  "email": "lucas@email.com",
  "password": "123456"
}
```
e responde com:
```
{
    "acess_token": "1|eTwo4Gk7lCEzD6cUhXf1rrpPEYEPwR6pL7c1wT84e0cb0d86",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "name": "lucas",
        "email": "lucas@email.com",
        "email_verified_at": null,
        "created_at": "2025-08-04T18:42:25.000000Z",
        "updated_at": "2025-08-04T18:42:25.000000Z"
    }
}
```
## Busca de Pokemon
* `GET : /api/pokemons/geracao/{numero da geração}`: busca todos os pokemons da geração passada na URL, responde com:
```
...
{
    "id": 2,
    "name": "ivysaur",
    "sprite": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/2.png",
    "types": [
        "grass",
        "poison"
    ]
},
...
```
## Times
* `POST : /api/teams` : Cria times para o usuario autenticado, é uma rota protegida pelo middware do Sanctum, precisa que seja enviado no header: 
```
Authorization: Bearer {token}
``` 
e no body, os dados do time a ser criado:
```
{
  "name": "Time de Lucas",
    "pokemons": [
    {
      "name": "bulbasaur",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/1.png",
      "types": ["grass", "poison"]
    },
    {
      "name": "totodile",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/158.png",
      "types": ["water"]
    },
    {
      "name": "torchic",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/255.png",
      "types": ["fire"]
    },
    {
      "name": "piplup",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/393.png",
      "types": ["water"]
    },
    {
      "name": "snivy",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/495.png",
      "types": ["grass"]
    }
  ]
}

```
* `PUT : /api/teams/{id do time}/pokemons` : Altera a lista de pokemons atual do time pela que foi enviada, tambem é uma rota protegida, então precisa do header: 
```
Authorization: Bearer {token}
``` 
e no corpo a lista dos novos pokemons da equipe:
```
{
  "pokemons": [
    {
      "name": "bulbasaur",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/1.png",
      "types": ["grass", "poison"]
    },
    {
      "name": "charmander",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/4.png",
      "types": ["fire"]
    },
    {
      "name": "squirtle",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/7.png",
      "types": ["water"]
    },
    {
      "name": "pikachu",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png",
      "types": ["electric"]
    },
    {
      "name": "eevee",
      "image_url": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/133.png",
      "types": ["normal"]
    }
  ]
}
```
* `DELETE: /api/teams/{id do time}`: Remove um time do usuario, tambem é uma rota protegida então precisa do header: 
```
Authorization: Bearer {token}
``` 

## Utilitario
* `GET : /api/perfil` : Retorna os dados do usuario autenticado, rota protegida então envie nos headers: 
```
Authorization: Bearer {token}
``` 