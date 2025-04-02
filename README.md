# Sistema de Cadastro de Funcionários

## 📝 Descrição

Este repositório contém um sistema completo para cadastro e gerenciamento de funcionários, desenvolvido em PHP com Bootstrap para a interface. O sistema permite:

- Cadastrar novos funcionários com informações pessoais e departamentais
- Visualizar todos os registros em uma tabela dinâmica
- Filtrar funcionários por departamento
- Editar e remover registros
- Exportar relatórios em PDF

## 🛠 Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Backend**: PHP 8+
- **Banco de Dados**: MySQL
- **Bibliotecas**:
  - FPDF para geração de PDFs
  - Bootstrap Icons

## 🚀 Funcionalidades Principais

1. **Cadastro de Funcionários**
   - Nome completo
   - CPF (com validação)
   - E-mail
   - Seleção de departamento

2. **Consulta Avançada**
   - Tabela responsiva
   - Filtros por departamento
   - Paginação (em desenvolvimento)

3. **Gerenciamento**
   - Edição direta na tabela
   - Exclusão com confirmação

4. **Relatórios**
   - Exportação para PDF
   - Manutenção dos filtros aplicados
   - Formatação profissional

## ⚙️ Instalação

1. Clone o repositório:
```bash
git clone https://github.com/GabrielRLemos/Cadastro.git
cd Cadastro
```

2. Configure o banco de dados:
- Importe o arquivo `database.sql` para seu MySQL
- Ajuste as credenciais em `connection.php`

3. Instale as dependências:
```bash
composer install
```

4. Configure seu servidor web (Apache/Nginx) para apontar para a pasta do projeto

## 📊 Estrutura do Banco de Dados

Tabelas principais:
```sql
CREATE TABLE departamento (
    id_departamento INT AUTO_INCREMENT PRIMARY KEY,
    nome_departamento VARCHAR(50) NOT NULL
);

CREATE TABLE funcionarios (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome_funcionario VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    id_departamento INT NOT NULL,
    FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento)
);
```

## ✉️ Contato

Gabriel Lemos - [gabriel97rl@gmail.com](mailto:gabriel97rl@gmail.com)

Link do Projeto: [https://github.com/GabrielRLemos/Cadastro](https://github.com/GabrielRLemos/Cadastro)

---
