# Invoices - Sistema de Gerenciamento de Faturas 🧾

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

**Status do Projeto:** Finalizado para entrega acadêmica.

---

**Invoices** é um sistema web completo e funcional para cadastro de usuários e gerenciamento de suas faturas. O projeto foi desenvolvido com PHP puro, JavaScript (AJAX), HTML e CSS, utilizando uma arquitetura segura, moderna e responsiva.

## ✨ Funcionalidades Implementadas

* 🔑 **Autenticação Segura:** Sistema completo de Cadastro e Login com senhas criptografadas (`password_hash`).
* ⚡ **Comunicação Assíncrona (AJAX):** Login e Cadastro são realizados sem recarregamento da página, proporcionando uma experiência de usuário fluida.
* 📊 **Dashboard de Faturas:** Usuários logados visualizam uma lista de suas faturas com status visuais ("Paga", "Pendente", "Vencida").
* 📄 **Detalhes da Fatura:** Visualização de informações detalhadas de cada fatura, incluindo código de barras.
* 💳 **Simulação de Pagamento:** Funcionalidade de marcar uma fatura como "Paga" com atualização instantânea na interface, sem recarregar a página.
* 🛡️ **Validação Frontend:** Confirmação de senha em tempo real e máscaras de campo para CPF e Data de Nascimento, melhorando a usabilidade e a integridade dos dados.
* 📱 **Design Responsivo (Mobile-First):** A interface se adapta perfeitamente a qualquer tamanho de tela, de celulares a desktops, seguindo as melhores práticas de desenvolvimento.

## 🎨 Paleta de Cores e Design

O design foi pensado para ser limpo, moderno e intuitivo, utilizando uma paleta de cores contrastante para facilitar a leitura e a identificação de ações.

| Cor                   | Hexadecimal | Uso Principal                               |
| --------------------- | ----------- | ------------------------------------------- |
| **Preto (Quase)** | `#1a1a1a`   | Cabeçalho, Rodapé, Botões Primários         |
| **Azul Primário** | `#007BFF`   | Links, Destaques, Valores Monetários        |
| **Gradiente Verde/Azul** | `#1ddde8`   | Fundo da seção promocional                  |
| **Cinza Claro** | `#f8f9fa`  | Fundo principal da página                   |
| **Branco** | `#FFFFFF`   | Texto sobre fundos escuros, fundo de cards  |

## 🛠️ Tecnologias Utilizadas

* **Backend:** **PHP 8+** (Puro, sem frameworks)
    * Utilizado para toda a lógica de servidor, incluindo autenticação, interação com o banco de dados e criação das APIs.
* **Frontend:** **HTML5, CSS3, JavaScript (ES6+)**
    * **JavaScript** é usado para manipulação do DOM, validações, máscaras de campo e para toda a comunicação assíncrona com o backend via `fetch()`.
* **Banco de Dados:** **MySQL / MariaDB**
    * Utilizado para a persistência de dados de usuários e faturas.
* **Servidor Local:** **XAMPP** (Windows) / **MAMP** (macOS)
    * Ambiente de desenvolvimento que provê Apache, MySQL e PHP.
* **Versionamento:** **Git & GitHub**
    * Utilizado para controle de versão e documentação do progresso do projeto.

---

## 🚀 Como Rodar o Projeto

Siga os passos abaixo para configurar e executar o projeto em seu ambiente de desenvolvimento local.

### **Pré-requisitos**

Você precisará de um ambiente de servidor local com Apache, MySQL e PHP. As opções mais comuns e recomendadas são:

* **Para Windows:** [**XAMPP**](https://www.apachefriends.org/index.html)
* **Para macOS:** [**MAMP**](https://www.mamp.info/en/mamp/mac/)

### **Instruções de Instalação (Passo a Passo)**

1.  **Clone o Repositório**
    Abra seu terminal (Prompt de Comando, PowerShell, ou Terminal do Mac), navegue até o diretório onde deseja salvar o projeto e clone o repositório:
    ```bash
    git clone [https://github.com/Omatheus31/invoices.git](https://github.com/Omatheus31/invoices.git)
    ```

2.  **Mova a Pasta do Projeto**
    Mova a pasta `invoices` que você acabou de clonar para o diretório raiz do seu servidor web. Este diretório é chamado `htdocs` tanto no XAMPP quanto no MAMP.
    * **Localização no XAMPP (Windows):** `C:/xampp/htdocs/`
    * **Localização no MAMP (macOS):** `/Applications/MAMP/htdocs/`

3.  **Inicie o Servidor Local**
    Abra o painel de controle do XAMPP ou MAMP e inicie os serviços **Apache** e **MySQL**.

4.  **Crie o Banco de Dados**
    * Abra seu navegador e acesse o phpMyAdmin: `http://localhost/phpmyadmin`.
    * Clique em **"Novo"** (ou "New") na barra lateral para criar um banco de dados.
    * No campo "Nome do banco de dados", digite `invoices_db` e clique em **"Criar"** (ou "Create").

5.  **Execute o Script SQL de Instalação**
    * Com o banco `invoices_db` selecionado, clique na aba **"SQL"** no topo da página.
    * No seu computador, abra o arquivo `database_setup.sql` que está na raiz do projeto `invoices/`.
    * Copie **todo o conteúdo** do arquivo.
    * Cole o conteúdo na caixa de texto da aba SQL no phpMyAdmin e clique em **"Executar"** (ou "Go").
    * Este script criará e configurará todas as tabelas e dados de exemplo necessários.

6.  **Acesse a Aplicação**
    Pronto! A instalação está completa. Abra uma nova aba no seu navegador e acesse:
    [**http://localhost/invoices/public/**](http://localhost/invoices/public/)

    Você será direcionado para a tela de login.

### **🧪 Credenciais para Teste**

Para testar o sistema imediatamente, use o usuário de exemplo que o script SQL criou:

* **Email:** `joao.silva@example.com`
* **Senha:** `senha123`

---

### **🧑‍💻 Autor**

* **Matheus Sousa**
    * GitHub: [@Omatheus31](https://github.com/Omatheus31)

---
*Projeto desenvolvido como parte de avaliação acadêmica, com foco em boas práticas de programação, segurança e experiência do usuário.*