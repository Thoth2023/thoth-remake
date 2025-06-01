# Documentação da Arquitetura - Thoth 2.0

## 1. Visão Geral

O Thoth 2.0 é uma aplicação web para Revisão Sistemática de Literatura (RSL), desenvolvida com Laravel 10.x e utilizando o padrão MVC (Model-View-Controller). A aplicação permite aos pesquisadores gerenciar projetos de revisão de literatura de forma sistemática, desde o planejamento até a condução e relatório final.

## 2. Stack Tecnológica

- **Backend**: PHP 8.1+, Laravel 10.x
- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Framework JS**: Vue.js 
- **Banco de Dados**: MySQL (deduzido pela estrutura Laravel)
- **Contêinerização**: Docker
- **Outras ferramentas**: Webpack, Git, Chart.js

## 3. Estrutura de Arquitetura

### 3.1 Camadas Principais

1. **Camada de Apresentação**
   - Views (Blade templates): `resources/views/`
   - JavaScript: `resources/js/`
   - CSS/SCSS: `resources/css/`, `resources/scss/`

2. **Camada de Negócios**
   - Controllers: `app/Http/Controllers/`
   - Models: `app/Models/`
   - Services: implícitos nos controllers

3. **Camada de Dados**
   - Migrations: `database/migrations/`
   - Seeds: `database/seeders/`

### 3.2 Componentes Principais

#### Models (`app/Models/`)
Representam as entidades de negócio e suas relações:
- `Project.php`: Modelo central para projetos de revisão
- `User.php`: Usuários do sistema
- `Study.php`: Estudos incluídos na revisão
- `Paper.php`: Artigos analisados
- `SearchString.php`: Strings de busca para a revisão
- `Database.php`: Bases de dados para pesquisa
- Diversos outros modelos relacionados

#### Controllers (`app/Http/Controllers/`)
Gerenciam a lógica de negócios e o fluxo de dados:

1. **Controllers Principais**
   - `ProjectController.php`: Gerenciamento de projetos
   - `UserProfileController.php`: Perfis de usuário
   - `HomeController.php`: Página inicial

2. **Controllers de Projeto - Planejamento** (`app/Http/Controllers/Project/Planning/`)
   - `ResearchQuestionsController.php`: Questões de pesquisa
   - `SearchStringController.php`: Strings de busca
   - `CriteriaController.php`: Critérios de inclusão/exclusão
   - `SearchStrategyController.php`: Estratégias de busca
   - `DatabaseController.php`: Bases de dados

3. **Controllers de Projeto - Condução** (`app/Http/Controllers/Project/Conducting/`)
   - `StudySelectionController.php`: Seleção de estudos
   - `ConductingController.php`: Condução geral da RSL
   - Subcontrollers para extração de dados

4. **Controllers de Projeto - Relatório**
   - `ReportingController.php`: Geração de relatórios
   - `ExportController.php`: Exportação de dados

#### Views (`resources/views/`)
Templates Blade organizados por funcionalidade:
- `layouts/`: Layouts principais
- `auth/`: Autenticação
- `project/`: Views relacionadas a projetos
- `components/`: Componentes reutilizáveis

#### Middleware
Controlam acesso e processamento de requisições:
- Autenticação e autorização
- Gerenciamento de permissões via Spatie/Permission

## 4. Fluxos Principais

### 4.1 Fluxo de Revisão Sistemática de Literatura

1. **Planejamento**
   - Definição de questões de pesquisa
   - Criação de strings de busca
   - Definição de critérios de inclusão/exclusão
   - Seleção de bases de dados
   - Configuração de avaliação de qualidade

2. **Condução**
   - Seleção de estudos
   - Extração de dados
   - Avaliação de qualidade
   - Snowballing (técnica de rastreamento de referências)

3. **Relatório**
   - Geração de relatórios
   - Exportação de dados
   - Análise de resultados

## 5. Áreas de Modificação

Baseado na estrutura do código, aqui estão as áreas onde modificações específicas devem ser feitas:

1. **Modificações em Modelos de Dados** (`app/Models/`)
   - Alterar estrutura de entidades: modificar os respectivos arquivos Model
   - Adicionar novas entidades: criar novos Models e suas migrações

2. **Modificações de Regras de Negócio** (`app/Http/Controllers/`)
   - Alterar fluxos de planejamento: modificar controllers em `Project/Planning/`
   - Alterar fluxos de condução: modificar controllers em `Project/Conducting/`
   - Alterar fluxos de relatório: modificar `ReportingController.php`

3. **Modificações de Interface** (`resources/views/`)
   - Alterar layouts: modificar arquivos em `layouts/`
   - Alterar páginas específicas: modificar os respectivos arquivos Blade
   - Alterar estilos: modificar arquivos em `resources/scss/` ou `resources/css/`
   - Alterar comportamento cliente: modificar arquivos em `resources/js/`

4. **Modificações de Banco de Dados**
   - Alterar esquema: criar novas migrações em `database/migrations/`
   - Alterar dados iniciais: modificar seeders em `database/seeders/`

5. **Configurações da Aplicação** (`config/`)
   - Alterar configurações gerais do sistema

## 6. Considerações para Evolução

1. **Escalabilidade**: Considerar refatoração para padrões de Service/Repository para melhor separação de responsabilidades

2. **API**: Implementar endpoints de API para maior interoperabilidade

3. **Testes**: Ampliar cobertura de testes para garantir estabilidade durante o desenvolvimento

4. **Documentação**: Manter documentação atualizada para facilitar a manutenção 