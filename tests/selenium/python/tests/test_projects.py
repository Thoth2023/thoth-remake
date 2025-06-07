import time
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.edit import EditProjectPage
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

# SeTC.003.2 - Editar projeto
def test_edit_project(driver):
    """
    Verificar se é possível editar um projeto com os campos obrigatórios preenchidos.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.find_by_title_and_edit("Título Teste")
    time.sleep(1) # Pausa após clicar em editar

    edit_project_page = EditProjectPage(driver)
    title = "Título Teste1"
    edit_project_page.edit(title, "Descrição Teste1", "Objetivos Teste1")
    time.sleep(1) # Pausa após a edição para a página de projetos recarregar

    assert projects_page.find_by_title(title), f"O projeto '{title}' não foi encontrado na tabela."

# SeTC.003.3 - Excluir projeto
def test_delete_project(driver):
    """
    Verificar se é possível excluir um projeto previamente criado.
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()

    title = "Título Teste1"
    projects_page.find_by_title_and_delete(title)
    time.sleep(1) # Pausa para a tabela ser atualizada após a exclusão

    assert not projects_page.find_by_title(title), f"O projeto '{title}' ainda foi encontrado após a exclusão."
