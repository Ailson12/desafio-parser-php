# Projeto API de Produtos

Este projeto é uma API desenvolvida com o Laravel para gerenciar produtos. Ela fornece endpoints para CRUD (Create, Read, Update, Delete) de produtos, com paginação e status de importação, utilizando o Laravel Sail para o ambiente de desenvolvimento.

## Funcionalidades

- **Cadastro de Produtos**
- **Listagem de Produtos com Paginação**
- **Visualização de Detalhes de um Produto**
- **Atualização de Produtos**
- **Remoção de Produtos**
- **Importação de Dados de Produtos via Open Food Facts**
- **Status da API (Uptime e Uso de Memória)**

## Tecnologias Utilizadas

- **Laravel 12.x**
- **MySQL (via Laravel Sail)**
- **PHP 8.x**
- **Composer**
- **Swagger (OpenAPI 3.0) para documentação da API**

## Requisitos

Antes de iniciar, certifique-se de ter os seguintes softwares instalados:

- Docker
- Docker Compose

## Configuração do Ambiente de Desenvolvimento

Este projeto usa o **Laravel Sail**, uma solução de desenvolvimento baseada em Docker. Para configurar o ambiente de desenvolvimento:

1. **Clone o repositório:**

   ```
   git clone https://seu-repositorio.git
   ```
   cd nome-do-repositorio

2. **Instale as dependências do Laravel Sail:**

   ```
   ./vendor/bin/sail up -d
   ```


3. **Instale as dependências do Laravel:**

   ```
   ./vendor/bin/sail composer install
   ```

4. **Crie um arquivo .env a partir do exemplo fornecido:**

   ```
   cp .env.example .env
   ```

5. **Gere a chave de aplicativo do Laravel:**

   ```
   ./vendor/bin/sail artisan key:generate
   ```

6. **Rodar as migrations para configurar o banco de dados:**

   ```
   ./vendor/bin/sail artisan migrate
   ```

7. **Rodar o servidor de desenvolvimento:**

   ```
   Acesse o navegador e vá para http://localhost, onde a API estará disponível.
   ```

## Práticas de Desenvolvimento e Arquitetura

Este projeto foi desenvolvido com foco em escalabilidade, manutenibilidade e testes, aplicando padrões de projeto, princípios SOLID, DDD e Clean Architecture.

### Princípios SOLID

### Clean Architecture

- **Independência de frameworks**: O núcleo da aplicação (domínio e casos de uso) não depende do Laravel ou Eloquent.
- **Testabilidade**: Casos de uso e regras de negócio podem ser testados isoladamente.
- **Separação de camadas**:
  - **Domínio**: Entidades e enums puros.
  - **Aplicação**: Casos de uso (Use Cases) e DTOs.
  - **Infra**: Repositórios e serviços que lidam com Laravel/Eloquent.

### Domain-Driven Design (DDD)

- **Entidades**: Representam conceitos de negócio com regras próprias (ex: `Product`).
- **Enums**: Controlam estados específicos (`ProductStatusEnum`).
- **Use Cases**: Contêm regras de aplicação (`ListProductsUseCase`, `UpdateProductUseCase`, etc).
- **DTOs**: Objetos de transporte de dados entre camadas sem acoplamento.
- **Repositórios**: Contratos de persistência desacoplados da implementação.

### Design Patterns Utilizados

- **Repository Pattern**: Abstrai a persistência dos dados.
- **DTO (Data Transfer Object)**: Padroniza a comunicação entre camadas.
- **Command Pattern**: Aplicado ao Artisan Command para importação (`php artisan openfood:import`).
- **Mapper Pattern**: Conversão entre entidades de domínio e modelos de infraestrutura.
- **Value Object Pattern**: Encapsula atributos relacionados e imutáveis com comportamento específico.

Estas práticas contribuem para um sistema **limpo**, **modular**, **flexível**, e **fácil de evoluir** com qualidade.


## Endpoints da API
`/products`
Método: GET
Descrição: Retorna a lista de produtos com paginação.
Query Params:
page (default: 1)
per_page (default: 10)

`/products/{code}`
Método: GET
Descrição: Retorna os detalhes de um produto pelo seu código.

`/products/{code}`
Método: PUT
Descrição: Atualiza os detalhes de um produto existente.
Parâmetros:
code (código único do produto)
Dados do produto para atualização

`/products/{code}`
Método: DELETE
Descrição: Remove um produto do banco de dados.
Parâmetros: code (código único do produto)

`/status`
Método: GET
Descrição: Retorna o status da API, incluindo informações sobre a conexão com o banco de dados, uptime e uso de memória.

## Docker - Laravel Sail

Laravel Sail é uma solução de desenvolvimento baseada em Docker, permitindo que você desenvolva e teste sua aplicação Laravel de forma eficiente e fácil. Para parar os containers, use:
```
   ./vendor/bin/sail down
```

### Se precisar de mais informações ou ajuda para rodar o projeto, entre em contato!
