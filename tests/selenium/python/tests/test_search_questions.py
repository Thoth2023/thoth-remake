import time
from selenium.webdriver.common.by import By
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.tabs.view import ViewProjectPage
from pages.projects.search_questions.index import SearchQuestionsPage
from utils.web_functions import login


title = "Meu Projeto Teste"
id_search_question = "SQ01"
new_id_search_question = "SQ00"

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


# SeTC006.1 - Inserir Questão de Pesquisa
def test_insert_search_question(driver):
    """
    Verificar se é possível criar questões de pesquisa em um projeto.
    """
    login(driver)
    time.sleep(1)  # Pausa para garantir que o login seja concluído

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open(title)
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)  # Pausa para garantir que o scroll seja concluído

    search_questions_page.insert_search_question(id_search_question, f"Descrição da questão de pesquisa {id_search_question}")
    time.sleep(2)  # Pausa para garantir que a questão seja criada

    assert search_questions_page.check_search_question_exists(id_search_question), f"A questão de pesquisa {id_search_question} não foi criada com sucesso."


# SeTC006.2 - Inserir uma Questão de Pesquisa com mesmo ID
def test_insert_search_question_with_same_id(driver):
    """
    Verificar se não é possível criar questões de pesquisa com ID duplicado.
    """
    login(driver)
    time.sleep(1)  # Pausa para garantir que o login seja concluído

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open(title)
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()
    
    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)  # Pausa para garantir que o scroll seja concluído
    
    # Tentativa de inserir com o mesmo ID mas descrição diferente
    search_questions_page.insert_search_question(id_search_question, "Segunda descrição - não deve ser inserida")
    time.sleep(1)
    
    # Verifica se existe apenas uma questão com esse ID (não duas)
    question_count = search_questions_page.count_questions_with_id(id_search_question)
    
    assert question_count == 1, f"Encontradas {question_count} questões com ID {id_search_question}, deveria ter apenas 1"


# SeTC006.3 - Editar uma Questão de Pesquisa já existente
def test_edit_search_question(driver):
    """
    Verificar se é possível editar uma questão de pesquisa existente.
    """
    login(driver)
    time.sleep(1)  # Pausa para garantir que o login seja concluído

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open(title)
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(2)  # Pausa para garantir que o scroll seja concluído

    search_questions_page.find_by_id_and_edit(id_search_question)
    time.sleep(3)  # Pausa para garantir que a edição seja concluída
    
    # Edita a questão de pesquisa
    search_questions_page.edit_search_question(new_id_search_question, "Nova descrição da questão de pesquisa")
    time.sleep(3)  # Pausa para garantir que a edição seja concluída

    assert search_questions_page.check_search_question_exists(new_id_search_question), f"A questão de pesquisa {id_search_question} não foi editada com sucesso."


# SeTC006.4 - Excluir uma Questão de Pesquisa já existente
def test_delete_search_question(driver):
    """
    Verificar se é possível excluir uma questão de pesquisa previamente criada.
    """
    login(driver)
    time.sleep(1)  # Pausa para garantir que o login seja concluído

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open(title)
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(2)  # Pausa para garantir que o scroll seja concluído

    search_questions_page.find_by_id_and_delete(new_id_search_question)
    time.sleep(1)  # Pausa para a tabela ser atualizada após a exclusão

    assert not search_questions_page.check_search_question_exists(new_id_search_question), f"A questão de pesquisa {new_id_search_question} ainda foi encontrada após a exclusão."
