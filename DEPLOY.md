# 🚀 Deploy Operon Cortex na Hostinger

## Pré-requisitos

- Conta Hostinger com Hospedagem Premium ou Business
- Acesso ao hPanel
- Subdomínio configurado (ex: `atendimento.operonagents.com`)
- Git instalado no servidor (ou usar File Manager)

---

## 1. Configurar Subdomínio

1. Acesse **hPanel > Domínios > Subdomínios**
2. Crie: `atendimento.operonagents.com`
3. Aponte para pasta: `public_html/atendimento`
4. Aguarde propagação DNS (~5 minutos)

---

## 2. Configurar Banco de Dados MySQL

1. Acesse **hPanel > Bancos de Dados > MySQL**
2. Crie novo banco: `u123456789_operon`
3. Crie usuário com senha forte
4. Associe o usuário ao banco com **Todos os Privilégios**

### Importar Schema

1. Acesse **phpMyAdmin** via hPanel
2. Selecione o banco criado
3. Vá em **Importar**
4. Faça upload do arquivo: `database/schema_mysql.sql`
5. Clique em **Executar**

---

## 3. Upload dos Arquivos

### Opção A: Via Git (Recomendado)

```bash
# No terminal SSH da Hostinger
cd ~/public_html/atendimento
git clone https://github.com/SEU_USUARIO/operoncortex.git .
```

### Opção B: Via File Manager/FTP

1. Comprima o projeto (excluindo `node_modules/`)
2. Faça upload via File Manager
3. Extraia na pasta `public_html/atendimento`

---

## 4. Configurar Ambiente

### Criar arquivo .env

```bash
cd ~/public_html/atendimento
cp .env.example .env
nano .env
```

### Editar configurações:

```env
APP_ENV=production
DB_TYPE=mysql
DB_HOST=localhost
DB_NAME=u123456789_operon
DB_USER=u123456789_admin
DB_PASS=SuaSenhaSegura123!
```

---

## 5. Configurar Permissões

```bash
# Pastas com permissão de escrita
chmod 755 public/uploads
chmod 755 database

# Arquivos PHP
find . -type f -name "*.php" -exec chmod 644 {} \;

# Proteger .env
chmod 600 .env
```

---

## 6. Verificar SSL

1. Acesse **hPanel > SSL**
2. Ative o certificado gratuito para o subdomínio
3. Force HTTPS (já configurado no .htaccess)

---

## 7. Teste Final

Acesse: `https://atendimento.operonagents.com`

### Verificar:
- [ ] Página inicial carrega
- [ ] Login admin funciona (`admin@operon.com` / `admin123`)
- [ ] CSS carregado corretamente
- [ ] Upload de arquivos funciona
- [ ] Rotas funcionando (sem erros 404/500)

---

## 8. Segurança Pós-Deploy

### IMPORTANTE: Mudar credenciais admin!

1. Acesse phpMyAdmin
2. Execute:
```sql
UPDATE users SET password_hash = '$2y$10$SEU_HASH_AQUI' WHERE email = 'admin@operon.com';
```

Ou gere novo hash via PHP:
```php
echo password_hash('SuaNovaSenha', PASSWORD_DEFAULT);
```

---

## Estrutura Final no Servidor

```
public_html/
└── atendimento/
    ├── .env              # Configurações (NÃO versionar)
    ├── .htaccess         # Regras de roteamento
    ├── app/              # Código PHP
    ├── database/         # Schema (SQLite removido em produção)
    ├── lang/             # Traduções
    ├── public/           # Assets + index.php
    │   ├── assets/
    │   │   └── css/
    │   │       └── style.css
    │   ├── uploads/
    │   └── index.php
    └── tailwind.config.js
```

---

## Troubleshooting

### Erro 500
- Verifique logs: `hPanel > Estatísticas > Logs de Erro`
- Confirme PHP 8.0+ ativo
- Verifique permissões de arquivos

### CSS não carrega
- Execute `npm run build` localmente
- Faça upload do `public/assets/css/style.css`

### Erro de banco de dados
- Confirme credenciais no `.env`
- Verifique se schema foi importado
- Teste conexão no phpMyAdmin

---

## Manutenção

### Atualizar código
```bash
cd ~/public_html/atendimento
git pull origin main
```

### Limpar cache (se necessário)
```bash
# Limpar sessões antigas
rm -rf /tmp/sess_*
```

---

## Contato Suporte

Se algo der errado:
1. Verifique os logs no hPanel
2. Revise as configurações do `.env`
3. Teste as rotas manualmente

---

**Deploy concluído!** 🎉
