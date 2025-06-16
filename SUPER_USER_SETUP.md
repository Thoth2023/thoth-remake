# Configuração do Super Usuário

## Visão Geral

As credenciais do super usuário foram removidas do código das migrations por questões de segurança e agora são configuradas através de variáveis de ambiente.

### Migrations Corrigidas

- `2024_06_06_215353_user.php` - Migration principal de criação de usuários
- `2024_06_07_000256_remove_bcrypt.php` - Migration que remove bcrypt das senhas

## O que foi feito

1. **Remoção de Credenciais Hardcoded**: Removemos todas as credenciais do super usuário que estavam expostas diretamente no código das migrations
2. **Implementação de Variáveis de Ambiente**: Substituímos os valores fixos por chamadas para `env()` que buscam as credenciais nas variáveis de ambiente
3. **Proteção Condicional**: Adicionamos verificação para que o super usuário só seja criado se todas as variáveis estiverem definidas
4. **Arquivo de Exemplo**: Criamos um arquivo `env.example` com as variáveis necessárias

## Como Configurar

### Para Desenvolvimento Local

#### 1. Copie o arquivo de exemplo para .env

```bash
cp env.example .env
```

#### 2. Configure as variáveis do super usuário no arquivo .env

Edite o arquivo `.env` e defina as seguintes variáveis com valores seguros:

```env
SUPER_USER_EMAIL=seu_email_admin@dominio.com
SUPER_USER_USERNAME=seu_username_admin
SUPER_USER_PASSWORD=uma_senha_muito_segura_e_complexa
```

#### 3. Execute as migrations

Após configurar as variáveis de ambiente, execute:

```bash
php artisan migrate
```

### Para Ambiente de Produção

#### 1. Defina novas variáveis no arquivo .env de produção

Adicione as seguintes variáveis ao arquivo `.env` real do servidor de produção:

```env
SUPER_USER_EMAIL=admin@seudominio.com.br
SUPER_USER_USERNAME=administrador
SUPER_USER_PASSWORD=SenhaSeguraEComplexaParaProducao123!
```

#### 2. Remova o super usuário exposto atual do banco

Conecte ao banco de produção e execute:

```sql
DELETE FROM users WHERE email = 'superuser@superuser.com';
```

#### 3. Execute as migrations para aplicar a melhoria

```bash
php artisan migrate
```

Isso criará o novo super usuário com as credenciais seguras definidas nas variáveis de ambiente.

## O que acontece se as variáveis não estiverem definidas?

Se as variáveis `SUPER_USER_EMAIL`, `SUPER_USER_USERNAME` ou `SUPER_USER_PASSWORD` não estiverem definidas no arquivo `.env`, o super usuário não será criado automaticamente durante a migration. Isso é uma medida de segurança para evitar a criação de usuários com credenciais padrão.

## Verificando se o super usuário foi criado

Após executar a migration, você pode verificar se o super usuário foi criado usando:

```bash
php artisan tinker
```

E então executar:

```php
App\Models\User::where('role', 'SUPER_USER')->get();
``` 