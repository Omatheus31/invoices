# Sistema de Faturas - Invoices

**Invoices** é um sistema web simples, seguro e transparente para consulta de faturas, desenvolvido como uma alternativa clara e direta a sistemas complexos de mercado.

## ✨ Funcionalidades

* **Autenticação Segura:** Tela de login com validação de dados e senhas armazenadas com hash.
* **Dashboard Intuitivo:** Visualização clara de todas as faturas do usuário.
* **Status Visual:** Identificação rápida de faturas pagas, pendentes e vencidas.
* **Design Responsivo:** Experiência de uso consistente em desktops, tablets e celulares.
* **Tecnologia Pura:** Construído com PHP, HTML, CSS e JS puros, sem frameworks, para máxima leveza e simplicidade.

## 🎨 Paleta de Cores

| Cor               | Hexadecimal | Uso                  |
| ----------------- | ----------- | -------------------- |
| Azul Primário     | `#007BFF`   | Botões, links, valores |
| Cinza Escuro      | `#343a40`   | Cabeçalho, rodapé, títulos |
| Branco            | `#FFFFFF`   | Fundo de cards, texto |

## 🚀 Como Rodar o Projeto

Siga os passos abaixo para executar o projeto em seu ambiente local.

### **Pré-requisitos**

* **XAMPP:** Um ambiente de servidor local com Apache, MySQL e PHP.
    * [Download do XAMPP](https://www.apachefriends.org/index.html)

### **1. Clone ou Baixe o Repositório**

Primeiro, obtenha os arquivos do projeto. Se estiver usando Git, clone o repositório. Caso contrário, baixe e extraia o ZIP.

```bash
git clone <URL_DO_SEU_REPOSITORIO>
```

Coloque a pasta do projeto `invoices` dentro do diretório `htdocs` da sua instalação do XAMPP (geralmente `C:/xampp/htdocs/`).

### **2. Inicie o Servidor**

1.  Abra o **XAMPP Control Panel**.
2.  Inicie os serviços **Apache** e **MySQL**.

### **3. Crie e Configure o Banco de Dados**

1.  Acesse o phpMyAdmin em seu navegador: `http://localhost/phpmyadmin`.
2.  Crie um novo banco de dados chamado `invoices_db`.
3.  Selecione o banco `invoices_db`, vá para a aba **"SQL"** e execute o script SQL contido no arquivo de setup do banco de dados para criar as tabelas e inserir os dados de exemplo.
4.  Verifique se as credenciais no arquivo `config/database.php` correspondem às do seu ambiente MySQL. O padrão do XAMPP geralmente é:
    * `DB_HOST`: 'localhost'
    * `DB_USER`: 'root'
    * `DB_PASS`: '' (vazio)
    * `DB_NAME`: 'invoices_db'

### **4. Acesse o Sistema**

Abra seu navegador e acesse a URL:
[http://localhost/invoices/public/](http://localhost/invoices/public/)

Você será direcionado para a tela de login. Use as credenciais de teste para acessar:

* **Email:** `joao.silva@example.com`
* **Senha:** `senha123`

---
Projeto desenvolvido com foco na simplicidade e na experiência do usuário.