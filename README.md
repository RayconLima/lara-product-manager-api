# Desafio Full Stack

## Descrição
Desenvolvimento de uma API que permite que diferentes plataformas acessem e manipulem dados sobre produtos e categorias de forma padronizada e eficiente. Além disso, conterá com autenticação e implementação de um sistema de ACL para autorizar o acesso a dados.

## O que foi utilizado
Antes de começar a usar este projeto, é necessário ter o seguinte configurado em seu ambiente de desenvolvimento:

- PHP (versão 8.3 ou superior)
- Composer 2
- Laravel (versão 11.x)
- Banco de dados MySQL
- Docker e Docker-Compose

## Funcionalidades
- Produtos
- Categoria
- Usuários
- Papéis
- Permissões

## Atividades
- [x]   - Registro de produtos
- [x]   - Registro de categorias
- [x]   - Teste de integração

## Instalação
Siga as etapas abaixo para configurar o projeto em seu ambiente local:

1. Clone este repositório para sua máquina local:

```
git clone https://github.com/RayconBatista/lara-product-manager-api.git
```

2. Navegue até o diretório do projeto:

```
cd lara-product-manager-api
```

3. Crie um arquivo `.env` na raiz do projeto e configure-o com as informações do seu ambiente, incluindo as credenciais do banco de dados. 

4. Inicie o servidor de desenvolvimento com os containers do docker. usando o comando pela primeira vez
```
docker-compose up -d
```

5. Acesse o container da aplicação laravel
```
docker-compose exec app bash
```

### Dentro do container
6. Instale as dependências do Composer com o comando:

```
composer install
```

5. Gere a chave de aplicativo Laravel:

```
php artisan key:generate
```
6. Execute as migrações do banco de dados para criar as tabelas necessárias:

```
php artisan migrate
```

7. Se necessário, execute os *seeders* para preencher o banco de dados com dados de exemplo:

```
php artisan db:seed
```

## Frontend
O projeto desenvolvido com a ferramenta Vue 3, está na raiz do projeto:

```
cd /app-vue
```

O projeto estará acessível em `http://localhost:8099`.