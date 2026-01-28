# Guia de Deploy - Hostinger (Shared Hosting)

Este guia detalha os passos para colocar o **Operon Cortex** em produção na Hostinger.

## 1. Estrutura de Arquivos

A Hostinger usa `public_html` como raiz pública. O Operon Cortex foi adaptado para funcionar com uma estrutura de "Ponte".

### Opção A: Upload Seguro (Recomendado)
Coloque os arquivos sensíveis *fora* do `public_html` se o seu plano permitir acesso a pastas superiores.

```
/home/u12345/
├── operoncortex_core/       <-- Todo o código (app, vendor, .env, etc)
│   ├── app/
│   ├── vendor/
│   ├── .env
│   └── ...
└── domains/meudominio.com/
    └── public_html/         <-- Apenas o conteúdo de 'public' e o index.php ponte
        ├── assets/
        ├── index.php        <-- Ponte modificada para apontar para ../operoncortex_core/public/index.php
        └── .htaccess
```

### Opção B: Upload Padrão (Mais Fácil)
Se você não tiver acesso acima de `public_html`, faça o upload de **todo o projeto** para dentro de `public_html`. O arquivo `index.php` na raiz e o `.htaccess` já estão configurados para proteger as pastas sensíveis e redirecionar o tráfego.

**Passos:**
1. Compacte todo o projeto local (exceto `node_modules` e `.git`) em um `.zip`.
2. No Gerenciador de Arquivos da Hostinger, vá para `public_html`.
3. Faça upload do `.zip` e extraia.
4. Garanta que a estrutura fique assim:
   
   ```
   public_html/
   ├── app/
   ├── public/
   ├── vendor/
   ├── .env
   ├── .htaccess
   ├── index.php        <-- (Arquivo Ponte criado na raiz)
   └── ...
   ```

## 2. Banco de Dados

1. Crie um novo Banco de Dados MySQL no painel da Hostinger.
   - Anote: Nome do Banco, Usuário e Senha.
2. Abra o phpMyAdmin.
3. Importe o arquivo `database/schema_mysql.sql`.

## 3. Configuração (.env)

1. Renomeie o arquivo `.env.example` para `.env` (se ainda não existir).
2. Edite o `.env` no Gerenciador de Arquivos:

```ini
APP_URL=https://seudominio.com
DB_HOST=localhost
DB_NAME=u123456789_operon    <-- Use o nome exato da Hostinger
DB_USER=u123456789_admin
DB_PASS=SuaSenhaForte
```

## 4. Verificações Finais

1. **Permissões:** Garanta que as pastas `storage/` (se houver) e `public/uploads/` tenham permissão `755` ou `777` (se necessário para upload).
2. **PHP Version:** No painel da Hostinger, defina a versão do PHP para **8.2** ou superior.
3. **Extensions:** Verifique se as extensões `pdo_mysql`, `mbstring` e `gd` estão ativas.

## Solução de Problemas

- **Erro 404/500:** Verifique se o arquivo `.htaccess` está presente na raiz `public_html`.
- **Assets não carregam:** Verifique se a pasta `public/assets` existe. Se carregou todo o projeto na raiz, os assets devem estar acessíveis via `seudominio.com/public/assets/...` mas o `.htaccess` deve reescrever isso transparentemente.
  - *Nota:* O sistema foi configurado para tentar carregar de `/assets/` ou `/public/assets/` automaticamente.

---
**Deploy Pronto!** Acesse seu domínio para verificar.
