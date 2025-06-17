import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.edit import EditProjectPage
from utils.web_functions import login

def test_create_project_empty_fields(driver):
    """
    Verificar se o sistema rejeita a criação de projeto com campos vazios
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.create_project()

    create_project_page = CreateProjectPage(driver)
    create_project_page.create("", "", "")  # Campos vazios

    # Aguardar e coletar todas as mensagens de erro
    error_messages = WebDriverWait(driver, 5).until(
        EC.presence_of_all_elements_located((By.CLASS_NAME, "invalid-feedback"))
    )
    error_texts = [msg.text.lower() for msg in error_messages]
    
    assert any("the title field is required" in text for text in error_texts), f"Mensagens encontradas: {error_texts}"
    assert any("the description field is required" in text for text in error_texts), f"Mensagens encontradas: {error_texts}"
    assert any("the objectives field is required" in text for text in error_texts), f"Mensagens encontradas: {error_texts}"

def test_create_project_title_too_long(driver):
    """
    Verificar se o sistema rejeita títulos muito longos
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.create_project()

    create_project_page = CreateProjectPage(driver)
    titulo_longo = "a" * 256  # Título com 256 caracteres
    create_project_page.create(titulo_longo, "Descrição Teste", "Objetivos Teste")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.CLASS_NAME, "invalid-feedback"))
    )
    assert "must not be greater than 255 characters" in erro.text.lower()

def test_create_project_duplicate_title(driver):
    """
    Verificar se o sistema rejeita projetos com títulos duplicados
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    
    # Criar primeiro projeto
    projects_page.create_project()
    create_project_page = CreateProjectPage(driver)
    titulo = "Projeto Duplicado"
    create_project_page.create(titulo, "Descrição Teste", "Objetivos Teste")
    time.sleep(1)
    
    # Tentar criar segundo projeto com mesmo título
    projects_page.create_project()
    create_project_page.create(titulo, "Outra Descrição", "Outros Objetivos")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.CLASS_NAME, "invalid-feedback"))
    )
    assert "title has already been taken" in erro.text.lower()

def test_edit_project_empty_fields(driver):
    """
    Verificar se o sistema rejeita edição de projeto com campos vazios
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    time.sleep(1)  # Aguardar carregamento da página

    # Encontrar a primeira linha da tabela e seu botão de editar
    row = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "table.table tbody tr"))
    )

    # Scroll para o elemento antes de interagir
    driver.execute_script("arguments[0].scrollIntoView(true);", row)
    time.sleep(0.5)  # Pequena pausa para o scroll

    # Clicar no botão de editar usando o mesmo seletor do ProjectsPage
    edit_button = row.find_element(
        By.XPATH,
        ".//a[contains(@class, 'btn-outline-secondary') and contains(., 'Editar')]"
    )
    
    # Pegar o href do botão para verificar se vamos para a URL correta
    edit_url = edit_button.get_attribute("href")
    edit_button.click()
    
    # Aguardar até que estejamos na URL de edição
    WebDriverWait(driver, 10).until(
        lambda d: d.current_url == edit_url
    )
    time.sleep(1)  # Aguardar carregamento da página de edição

    # Tentar editar com campos vazios
    edit_project_page = EditProjectPage(driver)
    edit_project_page.edit("", "", "")

    # Aguardar e coletar todas as mensagens de erro
    error_messages = WebDriverWait(driver, 5).until(
        EC.presence_of_all_elements_located((By.CLASS_NAME, "invalid-feedback"))
    )
    error_texts = [msg.text.lower() for msg in error_messages]
    
    assert any("the title field is required" in text for text in error_texts), f"Mensagens encontradas: {error_texts}"
    assert any("the description field is required" in text for text in error_texts), f"Mensagens encontradas: {error_texts}"
    assert any("the objectives field is required" in text for text in error_texts), f"Mensagens encontradas: {error_texts}"