import time
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.tabs.view import ViewProjectPage
from utils.web_functions import login

# SeTC.003.1 - Criar novo projeto
def test_create_project(driver):
    """
    Verificar se é possível criar um projeto com os campos obrigatórios preenchidos.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.create_project()

    create_project_page = CreateProjectPage(driver)
    title = "Título Teste"
    create_project_page.create(title, "Descrição Teste", "Objetivos Teste")
    time.sleep(1) # Pausa após a criação para a página de projetos recarregar

    assert projects_page.find_by_title(title), f"O projeto '{title}' não foi encontrado na tabela."

# SeTC.003.4 - Verificar erro 500
def test_error(driver):

    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project()
    time.sleep(1)  # Aguarda o carregamento da página
    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento
    projects_page.open_tab_searchstring()
    time.sleep(1)  # Aguarda o carregamento da aba de busca

    #clica no botão de adicionar synônimos
    projects_page.add_synonyms()

# Verifica se o erro SQL
def test_sql_error(driver):

    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project()
    time.sleep(1)  # Aguarda o carregamento da página
    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento
    projects_page.open_tab_searchstring()
    time.sleep(1)  # Aguarda o carregamento da aba de busca

    term = "software erro"
    projects_page.write_search_term(term)
    time.sleep(1)  # Aguarda o carregamento do termo de busca

    projects_page.select_term(driver, term)
    time.sleep(1)  # Aguarda o carregamento do seletor de termos

    #clica no botão de adicionar sinônimos
    projects_page.add_synonyms()

def test_happy_way(driver):
    """
    Verifica se é possível adicionar um termo e seus sinônimos na aba de String de busca.
    """
    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project()
    time.sleep(1)  # Aguarda o carregamento da página
    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento
    projects_page.open_tab_searchstring()
    time.sleep(1)  # Aguarda o carregamento da aba de busca

    term = "software erro"
    projects_page.write_search_term(term)
    time.sleep(1)  # Aguarda o carregamento do termo de busca

    projects_page.select_term(driver, term)
    time.sleep(1)  # Aguarda o carregamento do seletor de termos

    synonyms = "Teste"
    projects_page.write_synonyms(synonyms)
    time.sleep(1)  # Aguarda o carregamento do botão de adicionar sinônimos

# SeTC.003.3 - Excluir projeto
def test_delete_project(driver):
    """
    Verificar se é possível excluir um projeto previamente criado.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()

    title = "Título Teste"
    projects_page.find_by_title_and_delete(title)
    time.sleep(1) # Pausa para a tabela ser atualizada após a exclusão

    assert not projects_page.find_by_title(title), f"O projeto '{title}' ainda foi encontrado após a exclusão."