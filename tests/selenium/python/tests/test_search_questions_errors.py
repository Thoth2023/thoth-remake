import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.tabs.view import ViewProjectPage
from pages.projects.search_questions.index import SearchQuestionsPage
from utils.web_functions import login

def test_insert_search_question_empty_fields(driver):
    """
    Verificar se o sistema rejeita questão de pesquisa com campos vazios
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)

    search_questions_page.insert_search_question("", "")  # Campos vazios

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "campos obrigatórios" in erro.text.lower()

def test_insert_search_question_duplicate_id(driver):
    """
    Verificar se o sistema rejeita questão de pesquisa com ID duplicado
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)

    # Criar primeira questão
    id_questao = "SQ01"
    search_questions_page.insert_search_question(id_questao, "Primeira descrição")
    time.sleep(1)

    # Tentar criar segunda questão com mesmo ID
    search_questions_page.insert_search_question(id_questao, "Segunda descrição")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "id já existe" in erro.text.lower()

def test_edit_search_question_empty_fields(driver):
    """
    Verificar se o sistema rejeita edição de questão com campos vazios
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)

    # Criar questão primeiro
    id_questao = "SQ02"
    search_questions_page.insert_search_question(id_questao, "Descrição original")
    time.sleep(1)

    # Tentar editar com campos vazios
    search_questions_page.find_by_id_and_edit(id_questao)
    search_questions_page.edit_search_question("", "")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "campos obrigatórios" in erro.text.lower()

def test_delete_nonexistent_search_question(driver):
    """
    Verificar se o sistema trata tentativa de deletar questão inexistente
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    # Tentar deletar questão que não existe
    search_questions_page.find_by_id_and_delete("SQXX")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "questão não encontrada" in erro.text.lower()

def test_insert_search_question_invalid_id_format(driver):
    """
    Verificar se o sistema rejeita IDs em formato inválido
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)

    search_questions_page.insert_search_question("123", "Descrição válida")  # ID numérico inválido

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "formato de id inválido" in erro.text.lower()

def test_insert_search_question_description_too_long(driver):
    """
    Verificar se o sistema rejeita descrições muito longas
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)

    descricao_longa = "a" * 1001  # Descrição com mais de 1000 caracteres
    search_questions_page.insert_search_question("SQ02", descricao_longa)

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "descrição muito longa" in erro.text.lower()

def test_edit_nonexistent_search_question(driver):
    """
    Verificar se o sistema trata tentativa de editar questão inexistente
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    # Tentar editar questão que não existe
    driver.execute_script(
        'document.querySelector("button[data-id=\'SQXX\'][data-action=\'edit\']").click()'
    )

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "questão não encontrada" in erro.text.lower()

def test_insert_search_question_special_characters(driver):
    """
    Verificar se o sistema trata corretamente IDs com caracteres especiais
    """
    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(1)

    search_questions_page.insert_search_question("SQ@#$%", "Descrição válida")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "caracteres inválidos no id" in erro.text.lower()

def test_edit_search_question_without_permission(driver):
    """
    Verificar se o sistema impede edição de questão por usuário sem permissão
    """
    login(driver)  # Login com usuário sem permissão
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    # Tentar editar questão sem permissão
    driver.execute_script(
        'document.querySelector("button[data-id=\'SQ01\'][data-action=\'edit\']").click()'
    )

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "sem permissão" in erro.text.lower()

def test_delete_search_question_without_permission(driver):
    """
    Verificar se o sistema impede exclusão de questão por usuário sem permissão
    """
    login(driver)  # Login com usuário sem permissão
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    search_questions_page = SearchQuestionsPage(driver)

    projects_page.load()
    search_questions_page.find_by_title_and_open("Meu Projeto Teste")
    search_questions_page.open_planning_tab()
    search_questions_page.open_search_questions_tab()

    # Tentar deletar questão sem permissão
    driver.execute_script(
        'document.querySelector("button[data-id=\'SQ01\'][data-action=\'delete\']").click()'
    )

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "sem permissão" in erro.text.lower() 