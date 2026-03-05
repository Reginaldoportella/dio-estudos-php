# 📚 Estudos PHP - DIO

Repositório de estudos do curso de **PHP** da [Digital Innovation One (DIO)](https://www.dio.me/).

## 🎯 Objetivo

Documentar e praticar os conceitos fundamentais de PHP, com foco em **Programação Orientada a Objetos (POO)** e boas práticas de desenvolvimento.

## 📂 Estrutura do Projeto

```
dio-estudos-php/
├── excecoes/                    # Tratamento de Exceções
│   ├── 01-apresentacao-visao-geral.php
│   ├── 02-o-que-sao-excecoes.php
│   ├── 03-pilha-de-excecoes.php
│   ├── 04-conceito-debug.php
│   ├── 05-hierarquia-excecoes.php
│   └── 06-tratamento-excecoes.php
│
├── namespaces/                  # Namespaces e Autoload
│   ├── 01-introducao-namespaces.php
│   ├── 02-declarando-namespaces.php
│   ├── 03-use-e-alias.php
│   ├── 04-autoload-manual.php
│   ├── 05-composer-autoload.php
│   └── 06-exemplo-pratico.php
│
├── poo/                         # Programação Orientada a Objetos
│   ├── 01-heranca-conceitos.php
│   ├── 02-sobrescrita-metodos.php
│   ├── 03-polimorfismo.php
│   ├── 04-classes-abstratas-vs-interfaces.php
│   ├── 05-exemplo-pratico-funcionarios.php
│   └── 06-resumo-exercicio.php
│
└── README.md
```

## 📖 Conteúdo

### 🔴 Exceções
- Visão geral e conceitos
- O que são exceções
- Pilha de exceções (stack trace)
- Conceito de debug
- Hierarquia de exceções
- Tratamento com try/catch/finally

### � Namespaces e Autoload
- **Introdução**: conceito e problema de conflitos
- **Declaração**: sintaxe e regras
- **Use e Alias**: importação e resolução de conflitos
- **Autoload Manual**: spl_autoload_register, PSR-4
- **Composer**: gerenciador de dependências e autoload
- **Exemplo Prático**: Mini sistema de e-commerce

### �🔵 POO - Pilares: Herança e Polimorfismo
- **Herança**: `extends`, `parent::`, modificadores de acesso
- **Sobrescrita de métodos**: override, `final`
- **Polimorfismo**: múltiplas formas, type hints
- **Classes Abstratas**: métodos abstratos e concretos
- **Interfaces**: contratos, implementação múltipla
- **Exemplo Prático**: Sistema de Funcionários (RH)

## 🚀 Como Executar

### Pré-requisitos
- PHP 8.0 ou superior instalado

### Executando os arquivos

```bash
# Clone o repositório
git clone https://github.com/Reginaldoportella/dio-estudos-php.git

# Entre na pasta
cd dio-estudos-php

# Execute qualquer arquivo
php poo/01-heranca-conceitos.php
php excecoes/06-tratamento-excecoes.php
```

## 🛠️ Tecnologias

- ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white) PHP 8.x

## 📝 Conceitos Aprendidos

| Conceito | Descrição |
|----------|-----------|
| `extends` | Herança de classes |
| `implements` | Implementação de interfaces |
| `abstract` | Classes e métodos abstratos |
| `interface` | Definição de contratos |
| `final` | Impede herança/sobrescrita |
| `parent::` | Acesso à classe pai |
| `instanceof` | Verificação de tipo |
| `try/catch` | Tratamento de exceções |
| `namespace` | Organização de código em espaços de nomes |
| `use` | Importação de classes/funções/constantes |
| `as` | Alias para resolver conflitos de nomes |
| `spl_autoload_register` | Carregamento automático de classes |
| `Composer` | Gerenciador de dependências e autoload |

## 📈 Progresso do Curso

- [x] Apresentação do Curso e Conceitos
- [x] Pilares: Abstração e Encapsulamento
- [x] Pilares: Herança e Polimorfismo
- [x] Tratamento de Exceções
- [ ] Namespaces e Autoload ⬅️ **Estudando agora**
- [ ] Encerramento

## 🤝 Contribuições

Este é um repositório de estudos pessoais, mas sugestões são bem-vindas!

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

⭐ Feito com dedicação durante os estudos na [DIO](https://www.dio.me/)
