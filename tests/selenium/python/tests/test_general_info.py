import time
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.planning.view import ViewProjectPage
from utils.web_functions import login

def test_create_project(driver):
    """
    Verificar se é possível criar um projeto com os campos obrigatórios preenchidos.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.create_project()

    create_project_page = CreateProjectPage(driver)
    title = "General_Info_Test"
    create_project_page.create(title, "Descrição Teste", "Objetivos Teste")
    time.sleep(1) # Pausa após a criação para a página de projetos recarregar

    assert projects_page.find_by_title(title), f"O projeto '{title}' não foi encontrado na tabela."

def test_domain_create(driver):
    """
    Verificar se é possível criar um domínio dentro de um projeto.
    """
    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project("General_Info_Test")

    time.sleep(1)  # Aguarda o carregamento da página

    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento

    projects_page.open_tab_general_info()
    time.sleep(1)  # Aguarda o carregamento da aba de informações gerais

    domain_name = "Domínio Teste"
    projects_page.write_domain(domain_name)
    time.sleep(1)  # Pausa para a tabela de domínios ser atualizada

def test_language_create(driver):
    """
    Verificar se é possível criar um idioma dentro de um projeto.
    """
    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project("General_Info_Test")

    time.sleep(1)  # Aguarda o carregamento da página

    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento

    projects_page.open_tab_general_info()
    time.sleep(1)  # Aguarda o carregamento da aba de informações gerais

    language = "Portuguese"
    projects_page.select_language(language)
    time.sleep(1)  # Pausa para a tabela de idiomas ser atualizada

def test_study_type(driver):
    """
    Verificar se é possível criar um tipo de estudo dentro de um projeto.
    """
    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project("General_Info_Test")

    time.sleep(1)  # Aguarda o carregamento da página

    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento

    projects_page.open_tab_general_info()
    time.sleep(1)  # Aguarda o carregamento da aba de informações gerais

    study_type = "Book"
    projects_page.select_study_type(study_type)
    time.sleep(1)  # Pausa para a tabela de tipos de estudo ser atualizada

def test_keywords_create(driver):
    """
    Verificar se é possível criar palavras-chave dentro de um projeto.
    """
    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project("General_Info_Test")

    time.sleep(1)  # Aguarda o carregamento da página

    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento

    projects_page.open_tab_general_info()
    time.sleep(1)  # Aguarda o carregamento da aba de informações gerais

    keyword = "Teste"
    projects_page.write_keywords(keyword)
    time.sleep(1)  # Pausa para a tabela de palavras-chave ser atualizada

def test_date_create(driver):
    """
    Verificar se é possível criar uma data dentro de um projeto.
    """
    login(driver)

    projects_page = ViewProjectPage(driver)
    projects_page.load()
    projects_page.open_project("General_Info_Test")

    time.sleep(1)  # Aguarda o carregamento da página

    projects_page.open_tab_planning()
    time.sleep(1)  # Aguarda o carregamento da aba de planejamento

    projects_page.open_tab_general_info()
    time.sleep(1)  # Aguarda o carregamento da aba de informações gerais

    date = "09/06/2025"
    final_date = "09/06/2026"
    projects_page.select_date(date, final_date)
    time.sleep(1)  # Pausa para a tabela de datas ser atualizada
    


def test_delete_project(driver):
    """
    Verificar se é possível excluir um projeto previamente criado.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()

    title = "General_Info_Test"
    projects_page.find_by_title_and_delete(title)
    time.sleep(1) # Pausa para a tabela ser atualizada após a exclusão

    assert not projects_page.find_by_title(title), f"O projeto '{title}' ainda foi encontrado após a exclusão."
