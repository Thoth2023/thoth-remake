import time
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.export.export import ExportPage
from utils.web_functions import login
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

title = "Título Teste"

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
    create_project_page.create(title, "Descrição Teste", "Objetivos Teste")
    time.sleep(1) # Pausa após a criação para a página de projetos recarregar

    assert projects_page.find_by_title(title), f"O projeto '{title}' não foi encontrado na tabela."

# SeTC.011.1 - Criar um projeto no overleaf
def test_create_latex_config(driver):

    abas_begin = driver.window_handles

    login(driver)

    projects_page = ProjectsPage(driver)
    export_page = ExportPage(driver)

    projects_page.load()
    export_page.find_by_title_and_open(title)

    export_page.create_latex_project()

    time.sleep(1) # Pausa após clicar em editar

    WebDriverWait(driver, 10).until(
    lambda d: len(d.window_handles) > len(abas_begin)
    )

    abas_end = driver.window_handles

    assert len(abas_end) == len(abas_begin) + 1, "Uma nova aba deveria ter sido aberta"

# SeTC.011.2 - Copiar o conteúdo latex

def test_copy_latex_content(driver):
    """
    Verifica se é possível copiar o conteúdo LaTeX do projeto.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    export_page = ExportPage(driver)

    projects_page.load()
    export_page.find_by_title_and_open(title)

    export_page.click_export_section()

    time.sleep(1)

    export_page.copy_latex_content()
    WebDriverWait(driver, 10).until(EC.alert_is_present())

    alert = driver.switch_to.alert

    assert "conteúdo copiado para a área de transferência!" in alert.text.lower()
