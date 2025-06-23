# Documentação - Componente Criteria (Livewire)

## Visão Geral

Componente Livewire para gerenciamento de critérios de inclusão e exclusão em projetos de planejamento.

**Autor:** Felipe H. Scherer  
**Localização:** `app/Livewire/Planning/Criteria/Criteria.php`

---

## Funcionalidades

- CRUD de critérios (criar, editar, excluir, visualizar)
- Tipos: Inclusão e Exclusão
- Sistema de regras: ALL, ANY, AT_LEAST
- Pré-seleção automática de critérios

---

## Campos

| Campo | Tipo | Validação | Descrição |
|-------|------|-----------|-----------|
| criteriaId | String | Obrigatório, máx. 20 chars, alfanumérico | ID único do critério |
| description | String | Obrigatório, máx. 255 chars | Descrição do critério |
| type | Array | Obrigatório | Inclusão ou Exclusão |

---

## Regras de Negócio

### Sistema de Regras
- **ALL**: Todos os critérios obrigatórios
- **ANY**: Qualquer critério aceito
- **AT_LEAST**: Critérios pré-selecionados obrigatórios

### Validações
- IDs únicos por projeto
- Formato alfanumérico para IDs
- Campos obrigatórios: ID, descrição, tipo

### Atualização Automática
- 0 selecionados → ANY
- Todos selecionados → ALL
- Alguns selecionados → AT_LEAST

---

## Métodos Principais

### mount()
Inicializa componente com dados do projeto atual.

### submit()
Valida e salva critério (criação ou edição).

### edit(criteriaId)
Carrega critério para edição.

### delete(criteriaId)
Remove critério e atualiza lista.

### changePreSelected(id, type)
Alterna pré-seleção e ajusta regras automaticamente.

### selectRule(rule, type)
Define regra específica e atualiza pré-seleções.

---

## Validações

- **criteriaId**: required|string|max:20|regex:/^[a-zA-Z0-9]+$/
- **description**: required|string|max:255
- **type**: required|array

---

## Dependências

- Model: Project, Criteria
- Utils: ActivityLogHelper, ToastHelper
- Sistema de tradução Laravel
- Validação Livewire

---

## Log de Atividades

Registra automaticamente:
- "Added a criteria"
- "Updated the criteria"
- "Deleted the criteria"
