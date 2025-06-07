# Automação de Testes com Selenium e Pytest

Este diretório contém scripts de automação de testes para a Thoth usando Selenium WebDriver e Pytest como framework de testes.

##  Estrutura de Pastas

O diretório está organizado utilizando o padrão Page Object Model (POM) para garantir que o código seja reutilizável, legível e de fácil manutenção.

```
selenium/
└── python/
    ├── pages/
    │   ├── login.py       # Page Object de Login
    │   ├── index.py       # Page Object da Entrada 
    │   └── ...            # Demais páginas
    │
    ├── tests/
    │   ├── conftest.py    # Fixtures do Pytest
    │   ├── test_login.py  # Arquivo de testes para a funcionalidade de login
    │   └── ...            # Demais arquivos de teste
    │
    ├── utils/
    │   ├── config.py      # Armazena dados reutilizáveis (ex: usuários, senhas)
    │   └── web_functions.py # Funções reutilizáveis (ex: login, logout, etc.)
    │
    ├──  README.md
    └──  requirements.txt     # Dependências do projeto Python
```

-   **`pages/`**: Contém as classes Page Object. Cada arquivo representa uma página da aplicação, mapeando seus elementos e as interações possíveis.
-   **`tests/`**: Contém os arquivos de teste. Os testes utilizam os métodos das Page Objects para executar as validações.
-   **`utils/`**: Contém módulos de suporte.
    -   `config.py`: Para centralizar dados de configuração.
    -   `web_functions.py`: Funções de alto nível que orquestram ações complexas usando as Page Objects, como um fluxo de login completo.
    -   `conftest.py`: Arquivo especial do Pytest para compartilhar fixtures (funções de setup/teardown) entre os testes.

## Pré-requisitos

-   Python 3.8+
-   Google Chrome (ou outro navegador de sua escolha)
-   ChromeDriver correspondente à versão do seu Google Chrome

## Instalação

1.  **Crie um ambiente virtual:**
    ```bash
    python -m venv venv
    ```

2.  **Inicie (Ative) o Ambiente Virtual:**
    -   **No Windows:**
        ```bash
        .\venv\Scripts\activate
        ```
    -   **No macOS ou Linux:**
        ```bash
        source venv/bin/activate
        ```

3.  **Instale as dependências:**
    ```bash
    pip install -r requirements.txt
    ```

## Inicialização
1.  **Inicie (Ative) o Ambiente Virtual:**
    *(Você deve ativar o ambiente toda vez que for trabalhar em testes)*.
    -   **No Windows:**
        ```bash
        .\venv\Scripts\activate
        ```
    -   **No macOS ou Linux:**
        ```bash
        source venv/bin/activate

2.  **Finalize (Desative) o Ambiente Virtual:**
    Quando terminar de trabalhar, você pode desativar o ambiente com o comando universal:
    ```bash
    deactivate
    ```
    

## Como Executar os Testes

Para executar todos os testes do projeto, abra o terminal na pasta `selenium/python` e execute o seguinte comando:

```bash
pytest
```

Para uma saída mais detalhada (verbosa):
```bash
pytest -v
```

Para ver o output de `print()`s durante a execução:
```bash
pytest -v -s
```

## Tecnologias Utilizadas

-   **Linguagem:** Python
-   **Automação Web:** Selenium
-   **Framework de Teste:** Pytest
