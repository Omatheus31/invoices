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
    Abra seu terminal, navegue até o diretório onde deseja salvar o projeto e clone o repositório:
    ```bash
    git clone [https://github.com/Omatheus31/invoices.git](https://github.com/Omatheus31/invoices.git)
    ```

2.  **Mova a Pasta do Projeto**
    Mova a pasta `invoices` para o diretório raiz do seu servidor web (`htdocs`).
    * **Localização no XAMPP (Windows):** `C:/xampp/htdocs/`
    * **Localização no MAMP (macOS):** `/Applications/MAMP/htdocs/`

3.  **Inicie o Servidor Local**
    Abra o painel de controle do XAMPP ou MAMP e inicie os serviços **Apache** e **MySQL**.

4.  **Crie o Banco de Dados**
    * Abra seu navegador e acesse o phpMyAdmin: `http://localhost/phpmyadmin`.
    * Crie um novo banco de dados com o nome `invoices_db`.

5.  **Execute o Script SQL de Instalação**
    * Com o banco `invoices_db` selecionado, clique na aba **"SQL"**.
    * Abra o arquivo `database_setup.sql` que está na raiz do projeto.
    * Copie todo o conteúdo e cole na caixa de texto do phpMyAdmin. Clique em **"Executar"** (ou "Go").
    * Este script criará as tabelas `users` e `invoices`, prontas para uso.

6.  **Acesse a Aplicação**
    Pronto! Abra uma nova aba no seu navegador e acesse:
    [**http://localhost/invoices/**](http://localhost/invoices/)
    *(Graças ao redirecionamento, você não precisa mais digitar `/public`)*

---

### 🧪 Primeiro Uso e Teste das Funcionalidades

O sistema começará com um banco de dados limpo. Siga os passos abaixo para testar todas as funcionalidades.

**1. Crie sua Conta:**
Na tela inicial (`http://localhost/invoices/`), clique em "Cadastre-se" e crie um novo usuário.

**2. Faça o Login:**
Após o cadastro, faça o login com as credenciais que você acabou de criar. Você será direcionado para um Dashboard vazio.

**3. Adicionando Faturas de Exemplo (Opcional, mas Recomendado):**
Para ver o dashboard e as funcionalidades em ação, você pode popular sua conta com faturas de exemplo de forma rápida.

* **a) Encontre seu ID de Usuário:**
    * Vá para o `phpMyAdmin` e abra a tabela `users`.
    * Localize o usuário que você acabou de criar e anote o número na coluna `id`.

* **b) Prepare o Script SQL:**
    * No código do projeto, abra o arquivo `sample_invoices.sql`.
    * Você **precisa substituir** todas as 4 ocorrências de `SEU_NOVO_ID_DE_USUARIO_AQUI` pelo número do `id` que você encontrou no passo anterior.

* **c) Execute o Script:**
    * Volte para o `phpMyAdmin`, clique no banco `invoices_db` e vá para a aba **"SQL"**.
    * Copie o conteúdo **modificado** do `sample_invoices.sql` e cole na caixa de texto.
    * Clique em **"Executar" (Go)**.

* **d) Veja a Mágica Acontecer:**
    * Volte para a aba do projeto no navegador e **atualize a página do Dashboard**. As 4 faturas de exemplo agora estarão listadas, prontas para você interagir (ver detalhes, marcar como paga, etc.).

---

## 💡 Melhorias Futuras e Próximos Passos

Este projeto serve como uma base sólida que pode ser expandida com diversas funcionalidades profissionais. Os próximos passos lógicos na evolução do sistema incluem:

* **Painel Administrativo:**
    * Criar uma área restrita para administradores com a capacidade de gerenciar usuários.
    * Implementar funcionalidades para que o administrador possa cadastrar, editar e excluir faturas para qualquer usuário do sistema.

* **API de Integração para Lojas (Webhook):**
    * Desenvolver um endpoint de API seguro onde sistemas externos (como os das lojas parceiras) possam enviar novas faturas para os clientes de forma automatizada, espelhando o funcionamento de sistemas reais.

* **Funcionalidades Adicionais para o Usuário:**
    * Edição de Perfil de Usuário: Permitir que o usuário altere seus dados pessoais e senha.
    * Geração de faturas em PDF.
    * Dashboard com gráficos de gastos.
    * Sistema de recuperação de senha por email.

---

### **🧑‍💻 Autor**

* **Matheus Sousa**
    * GitHub: [@Omatheus31](https://github.com/Omatheus31)

