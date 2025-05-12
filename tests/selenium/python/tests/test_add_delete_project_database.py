from pages.login import LoginPage
from pages.project import ProjectPage
from utils.config import USER, PASSWORD
from utils.web_functions import login, logout

# SeTC004.1 - Adicionar Base de Dados em um Projeto
def test_add_database(driver):
    """
    Verifica se é possível adicionar uma base de dados de um projeto.
    """
    login(driver)

    # Acessa a página do projeto
    project_page = ProjectPage(driver)
    project_page.load()

    # Clica no botão "Abrir" do projeto
    project_page.open_project()

    # Abre aba de Planejamento
    project_page.click_database_tab()

    # Adiciona a base de dados
    project_page.add_database("ACM (Association for Computing Machinery)")

    # Valida se a base foi adicionada com sucesso
    assert project_page.is_database_present("ACM (Association for Computing Machinery)"), "Base de dados não foi adicionada corretamente."

    # SeTC004.2 - Remover Base de Dados de um Projeto
def test_remove_database_from_project(driver):
    """
    Verifica se é possível remover uma base de dados previamente adicionada em um projeto.
    """
    login(driver)

    # Acessa a página do projeto
    project_page = ProjectPage(driver)
    project_page.load()

    # Clica no botão "Abrir" do projeto
    project_page.open_project()

    # Abre aba de Planejamento
    project_page.click_database_tab()

    # Verifica se a base está presente antes da exclusão
    assert project_page.is_database_present("ACM (Association for Computing Machinery)"), "Base não encontrada para remoção."

    # Remove a base de dados
    project_page.remove_database("ACM (Association for Computing Machinery)")

    # Valida se foi removida com sucesso
    assert not project_page.is_database_present("ACM (Association for Computing Machinery)"), "Base de dados não foi removida corretamente."