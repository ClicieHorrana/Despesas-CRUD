<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Projeto CRUD de Despesas

Este projeto é uma aplicação Laravel para gerenciamento de despesas com autenticação de usuário utilizando Sanctum. O sistema permite criar, ler, atualizar e excluir despesas e inclui notificações para o usuário quando uma nova despesa é criada.

## Tecnologias e Ferramentas

- **PHP:** 8.2.12
- **Laravel:** 10
- **Composer:** 2.7.7
- **Mailtrap:** Para teste de envio de e-mails
- **Insomnia:** Para testar as rotas da API
- **Swagger:** Para a documentação da API

## Requisitos

- PHP 8.2.12
- Composer 2.7.7

## Configuração do Projeto

1. **Clonar o Repositório:**

   Clone o repositório do projeto e entre no diretório do projeto.
   `git clone https://github.com/ClicieHorrana/Despesas-CRUD.git`

3. **Instalar as Dependências:**

   Instale as dependências do projeto usando o Composer.
   `Composer install`

5. **Configurar o Ambiente:**

   Renomeie o arquivo `.env.example` para `.env` e ajuste as variáveis de ambiente conforme necessário, incluindo configurações para o banco de dados e Mailtrap.

6. **Gerar a Chave de Aplicação:**

   Gere uma chave de aplicação Laravel para configurar a criptografia.
   `php artisan key:generate`

8. **Limpar os Caches do Laravel:**

   Limpe os caches do framework para garantir que todas as configurações sejam aplicadas corretamente.
   `php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    `

10. **Rodar as Migrações:**

   Execute as migrações para criar as tabelas no banco de dados.
    `php artisan migrate`
    
11. **Popular o Banco de Dados com Dados Iniciais:**

   Execute os seeders para adicionar dados iniciais ao banco de dados, como usuários.
    `php artisan db:seed`
    
11. **Testar as Rotas da API:**
    
   Utilize o Insomnia para testar as rotas da API. As rotas principais incluem:

   - **POST** `/api/login` - Autenticar um usuário
   - **POST** `/api/register` - Registrar um novo usuário
   - **GET** `/api/expenses` - Listar despesas
   - **POST** `/api/expenses` - Criar uma nova despesa
   - **GET** `/api/expenses/{expense}` - Visualizar uma despesa
   - **PATCH** `/api/expenses/{expense}` - Atualizar uma despesa
   - **DELETE** `/api/expenses/{expense}` - Excluir uma despesa

## Observer e Notificações

O projeto utiliza um observer para enviar uma notificação ao usuário sempre que uma nova despesa é criada. O observer escuta o evento de criação de uma despesa e aciona o envio de uma notificação.
    `php artisan queue:work`
- **Observer:** O observer é configurado para ouvir o evento de criação de uma despesa e notificar o usuário associado.
- **Notificação:** As notificações são enviadas utilizando o sistema de notificações do Laravel e podem ser configuradas para usar o Mailtrap durante o desenvolvimento.

## Roles e Permissões

O projeto inclui duas roles na tabela `users`:

- **admin:** Tem permissões completas para criar, editar e excluir despesas.
- **user:** Pode visualizar e criar despesas, mas não tem permissões para editar ou excluir.

## Ferramentas

- **Mailtrap:** Usado para testar o envio de e-mails durante o desenvolvimento.
- **Insomnia:** Utilizado para testar e documentar as rotas da API.
- **Swagger:** Utilizado para documentar as rotas da APIResources
  `php artisan l5-swagger:generate`

## Contribuição

Contribuições são bem-vindas! Se você encontrar problemas ou tiver sugestões, sinta-se à vontade para abrir uma issue ou enviar um pull request.

## Licença

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
