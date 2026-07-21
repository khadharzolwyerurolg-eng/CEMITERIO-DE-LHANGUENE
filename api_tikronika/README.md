# 📚 Bookerview — Biblioteca Virtual

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=flat&logo=mysql)
![MVC](https://img.shields.io/badge/Architecture-MVC-green?style=flat)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat)

**Bookerview** é uma biblioteca/livraria virtual desenvolvida em PHP puro com arquitectura **MVC (Model-View-Controller)**. O sistema permite aos utilizadores registarem-se, verificarem o email, autenticarem-se e acederem a uma vasta colecção de livros académicos, romances, ficção científica, e muito mais — directamente no browser, sem necessidade de downloads.

---

## ✨ Funcionalidades

- 📖 **Visualização de livros** — leitura de livros online nas categorias:
  - Académico
  - Romance
  - Ficção Científica
  - Literatura Clássica
  - Outros géneros
- 🔐 **Sistema de autenticação completo**
  - Registo de utilizador com validação de formulário
  - Login seguro com `password_hash` / `password_verify`
  - Logout com destruição de sessão
- ✉️ **Verificação de email**
  - Código de verificação gerado aleatoriamente
  - Código com prazo de validade (24 horas)
  - Bloqueio de acesso ao dashboard sem verificação
- 🛡️ **Protecção de rotas** — páginas privadas inacessíveis sem sessão activa
- 🗄️ **Base de dados MySQL** com PDO e prepared statements

---

## 🏗️ Arquitectura MVC

---

## 🗃️ Base de Dados

```sql
-- Tabela de utilizadores
CREATE TABLE users (
    id              INT(11)       NOT NULL AUTO_INCREMENT,
    username        VARCHAR(255)  NOT NULL,
    email           VARCHAR(255)  NOT NULL,
    email_verified  VARCHAR(255)  NULL,
    password        VARCHAR(255)  NOT NULL,
    date            DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de códigos de verificação
CREATE TABLE verify (
    id       INT(11)       NOT NULL AUTO_INCREMENT,
    code     INT(255)      NULL,
    expires  INT(255)      NULL,
    email    VARCHAR(255)  NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

---

## ⚙️ Instalação

### Requisitos
- PHP 8.x ou superior
- MySQL 8.x ou superior
- Apache / Nginx com `mod_rewrite` activo

### Passos

**1. Clonar o repositório**
```bash
git clone https://github.com/teu-usuario/bookerview.git
cd bookerview
```

**2. Configurar a base de dados**

Cria uma base de dados MySQL e importa as tabelas acima. Depois edita `app/core/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'bookerview');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'http://localhost/bookerview/');
```

**3. Configurar o Apache**

Certifica-te que o `mod_rewrite` está activo e que o `.htaccess` aponta para `index.php`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**4. Aceder no browser**
```
http://localhost/bookerview/
```

---

## 🔒 Fluxo de Autenticação

```
Signup ──► Verificação de Email ──► Login ──► Dashboard
                   │                             │
            Código enviado               check_login()
            por email (24h)              bloqueia acesso
```

1. O utilizador regista-se em `/signup`
2. É enviado um código de 5 dígitos para o email
3. O utilizador introduz o código em `/verify`
4. Após verificação, é redireccionado para `/dashboard`
5. Em sessões futuras, o login verifica automaticamente se o email já está verificado

---

## 🛡️ Segurança

| Medida | Implementação |
|---|---|
| Passwords encriptadas | `password_hash()` com `PASSWORD_DEFAULT` |
| Verificação de password | `password_verify()` no login |
| Prepared Statements | PDO com parâmetros nomeados |
| Protecção de rotas | `check_login()` em todas as páginas privadas |
| Sanitização de output | `htmlspecialchars()` nas views |
| Código de verificação | `random_int()` com prazo de validade |

---

## 🚀 Tecnologias Utilizadas

- **PHP 8** — lógica do servidor
- **MySQL** — base de dados relacional
- **PDO** — acesso à base de dados com prepared statements
- **MVC** — separação de responsabilidades via Traits
- **HTML/CSS** — interface do utilizador
- **Sessions PHP** — gestão de autenticação

---

## 👤 Autor

Desenvolvido por **Terdeu** — Projecto académico de biblioteca virtual com sistema de autenticação completo em PHP MVC.

---

## 📄 Licença

Este projecto está licenciado sob a licença **MIT** — podes usar, modificar e distribuir livremente com atribuição ao autor.
