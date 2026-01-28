# Operon Development Blueprint: O Manual da Tranquilidade

> **"Não estamos construindo apenas um CRUD. Estamos construindo uma ferramenta de redução de ansiedade."**

Este documento é a verdade absoluta para o desenvolvimento do Sistema Operon. Cada linha de código deve servir ao propósito de trazer clareza, velocidade e estabilidade.

---

## 1. Filosofia Técnica & Stack

Para atingir a "homeostase digital", o sistema deve ser **instantâneo**. Frameworks pesados (Laravel, Symfony) adicionam latência e complexidade desnecessária para este escopo. React/Vue trazem complexidade de build que pode ser excessiva.

**A Escolha: "The Zen Stack"**
- **Backend:** PHP 8.2+ Puro (Vanilla). Orientado a Objetos, sólido, sem dependências.
- **Database:** SQLite (Dev) / MySQL (Prod). Rápido, portátil, confiável.
- **Frontend:** HTML5 + Tailwind CSS (v3.4). Estilização atômica para UIs perfeitas.
- **Interatividade:** Vanilla JavaScript. ZERO jQuery. ZERO Frameworks JS pesados. Apenas manipulação de DOM cirúrgica para animações fluidas.

---

## 2. Estrutura de Diretórios (O Esqueleto)

Mantenha esta estrutura exata. Organização gera calma.

```
/operon
│
├── /app
│   ├── /Controllers    # Lógica de decisão (Córtex)
│   ├── /Models         # Acesso a dados (Memória)
│   ├── /Views          # Templates HTML (Visualização)
│   │   ├── /admin      # Visão do Operador
│   │   ├── /client     # Visão do Cliente
│   │   └── /layouts    # Estruturas base (Header, Footer)
│   └── /Core           # O cérebro do sistema (Router, DB, Auth)
│
├── /public             # Única pasta acessível via web
│   ├── index.php       # Ponto de entrada único
│   ├── /assets
│   │   ├── /css        # output.css do Tailwind
│   │   └── /js         # Scripts minimalistas
│
├── /config             # Credenciais e constantes
├── /database           # Scripts SQL e arquivo .sqlite
└── tailwind.config.js
```

---

## 3. Modelagem de Dados (A Memória)

Execute estes scripts SQL para criar a base neural do sistema.

### 3.1 Clientes (`clients`)
Simples, sem senhas complexas. O acesso é via token ou link mágico para reduzir atrito.
```sql
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    access_token VARCHAR(64) NOT NULL UNIQUE, -- O Segredo de Acesso
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### 3.2 Projetos (`projects`)
A entidade central.
```sql
CREATE TABLE projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    thalamic_setting VARCHAR(20) DEFAULT 'hybrid', -- 'macro', 'micro', 'hybrid'
    status VARCHAR(20) DEFAULT 'active', -- 'active', 'paused', 'completed'
    start_date DATE,
    deadline DATE,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
```

### 3.3 A Timeline Neural (`timeline_events`)
Onde a mágica acontece. A distinção `type` define o que aparece para quem.
```sql
CREATE TABLE timeline_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    project_id INTEGER NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    type VARCHAR(10) NOT NULL, -- 'MACRO' (Grande Marco) ou 'MICRO' (Detalhe Técnico)
    status VARCHAR(20) DEFAULT 'pending', -- 'pending', 'in_progress', 'done'
    completed_at DATETIME NULL,
    metadata TEXT, -- JSON para extras (pinned, progress, notifications)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);
```

### 3.4 O Córtex (`users`)
Apenas para nós (admins).
```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## 4. O Núcleo (Core System)

### 4.1 O Roteador (`Router.php`)
Não use libs de rota. Faça simples.
```php
class Router {
    protected $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function dispatch($uri, $method) {
        if (array_key_exists($uri, $this->routes[$method])) {
            // Instancia Controller e chama Método
            // Ex: ['ProjectController', 'index']
            call_user_func($this->routes[$method][$uri]);
        } else {
            http_response_code(404);
            require '../app/Views/404.php';
        }
    }
}
```

### 4.2 O Singleton de Banco (`Database.php`)
Performance máxima. Uma conexão por request.
```php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Use Variáveis de Ambiente na vida real
        $this->pdo = new PDO('sqlite:../database/operon.sqlite');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
```

---

## 5. Frontend & UX (A Experiência Calmante)

### 5.1 Design System (Tailwind)
Use cores que acalmam. Evite vermelho puro (`#FF0000`) para erros; prefira um laranja queimado ou rosa suave. O vermelho gera cortisol.

**Tokens Chave:**
- **Fundo:** `bg-slate-50` (Suavidade)
- **Cards:** `bg-white shadow-sm border border-slate-100` (Leveza)
- **Texto Principal:** `text-slate-800` (Contraste confortável)
- **Texto Secundário:** `text-slate-500` (Informação sem ruído)
- **Destaque (Macro):** `text-indigo-600`
- **Destaque (Micro):** `text-emerald-600`

### 5.2 Animações Essenciais
Nada deve "pipocar" na tela. Tudo deve deslizar.
Adicione no seu CSS global:
```css
.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
```

---

## 6. Passo a Passo de Desenvolvimento

1.  **Fundação:**
    *   Crie a estrutura de pastas.
    *   `npm init -y`
    *   `npm install -D tailwindcss`
    *   Configure `npx tailwindcss init`.
    *   Crie o arquivo `database/operon.sqlite`.

2.  **O Córtex (Backend):**
    *   Implemente `Database.php`.
    *   Implemente `Router.php`.
    *   Crie `public/index.php` para carregar tudo.

3.  **O Painel Admin (Input):**
    *   Crie `AdminController.php`.
    *   Faça a View de **Dashboard** (Listar projetos).
    *   Faça a View de **Projeto** (Adicionar eventos na Timeline).
    *   *Lembre-se do switch:* "Macro" vs "Micro".

4.  **A Visão do Cliente (Output):**
    *   Crie `ClientController.php`.
    *   Rota `/view/{token}`.
    *   A lógica de filtragem:
        *   Se `thalamic_setting` == 'macro', SELECT apenas WHERE type='MACRO'.
        *   Se `thalamic_setting` == 'micro', mostre tudo agrupado.

5.  **Polimento (UX):**
    *   Aplique as sombras suaves.
    *   Teste em Mobile (O cliente vai olhar pelo celular ansioso).
    *   Adicione o "Pulse" nos itens "In Progress".

---

**Nota Final:** Mantenha o código limpo. Comentários são bem-vindos, mas código legível é melhor. Se uma função tem mais de 20 linhas, ela provavelmente está fazendo duas coisas. Divida-a. Simplifique. A paz do código reflete na paz do usuário.
