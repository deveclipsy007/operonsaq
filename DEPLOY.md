# 🚀 Deploy Operon Cortex na Hostinger

## Estrutura Simplificada (Flat)

O projeto agora tem uma estrutura "plana", igual ao seu projeto que funcionou:

```
public_html/
├── .htaccess          # Segurança e HTTPS
├── config.php         # Configurações do sistema
├── db.php             # Conexão com banco
├── layout.php         # Template HTML
├── index.php          # Login (página inicial)
├── dashboard.php      # Dashboard admin
├── projects.php       # Lista de projetos
├── clients.php        # Lista de clientes
├── support.php        # Tickets de suporte
├── client_dashboard.php  # Portal do cliente
├── logout.php         # Logout
├── schema.sql         # Schema MySQL para phpMyAdmin
└── dist/css/          # CSS (se usar Tailwind compilado)
```

---

## 1. Configurar Banco MySQL

1. Acesse **hPanel > Bancos de Dados**
2. Use os dados que você já criou:
   - **Banco**: `u854567422_operonsaq`
   - **Usuário**: `u854567422_hello`
   - **Senha**: `Escher007.`

### Importar Schema

1. Acesse **phpMyAdmin**
2. Selecione `u854567422_operonsaq`
3. Vá em **Importar**
4. Upload do arquivo: `schema.sql`
5. Clique em **Executar**

---

## 2. Upload dos Arquivos

### Via Git:
```bash
cd ~/public_html
git clone https://github.com/deveclipsy007/operonsaq.git .
```

### Via FTP/File Manager:
1. Comprima todos os arquivos (exceto `node_modules/`)
2. Faça upload para `public_html`
3. Extraia

---

## 3. Verificar config.php

O arquivo `config.php` já está configurado com suas credenciais:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'u854567422_operonsaq');
define('DB_USER', 'u854567422_hello');
define('DB_PASS', 'Escher007.');
```

Se precisar mudar algo, edite diretamente este arquivo.

---

## 4. Teste Final

Acesse: `https://atendimento.operonagents.com`

**Login Admin:**
- Email: `admin@operon.com`
- Senha: `admin123`

> ⚠️ **IMPORTANTE**: Troque a senha do admin após o primeiro login!

---

## Páginas Disponíveis

| Arquivo | Descrição |
|---------|-----------|
| `index.php` | Login (clientes e admin) |
| `dashboard.php` | Dashboard administrativo |
| `projects.php` | Board de projetos (Kanban) |
| `project_show.php` | Detalhes do projeto + Timeline |
| `project_create.php` | Criar novo projeto |
| `clients.php` | Lista de clientes |
| `client_create.php` | Criar novo cliente |
| `client_dashboard.php` | Portal do cliente |
| `support.php` | Tickets de suporte |
| `logout.php` | Logout |

---

## Troubleshooting

### Erro 500
- Verifique se PHP 8.0+ está ativo no hPanel
- Confira as credenciais do banco em `config.php`

### Página em branco
- Edite `config.php` e mude `APP_ENV` para `development` para ver erros

### Login não funciona
- Confirme que o schema foi importado no phpMyAdmin
- Verifique se a tabela `users` tem o admin cadastrado

---

**Deploy concluído!** 🎉🧠🕶️
