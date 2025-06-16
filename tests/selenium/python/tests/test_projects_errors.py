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

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "campos obrigatórios" in erro.text.lower()

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
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "título muito longo" in erro.text.lower()

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
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "título já existe" in erro.text.lower()

def test_edit_project_empty_fields(driver):
    """
    Verificar se o sistema rejeita edição de projeto com campos vazios
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    
    # Criar projeto primeiro
    projects_page.create_project()
    create_project_page = CreateProjectPage(driver)
    titulo = "Projeto para Editar"
    create_project_page.create(titulo, "Descrição Teste", "Objetivos Teste")
    time.sleep(1)
    
    # Tentar editar com campos vazios
    projects_page.find_by_title_and_edit(titulo)
    edit_project_page = EditProjectPage(driver)
    edit_project_page.edit("", "", "")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "campos obrigatórios" in erro.text.lower()

def test_delete_nonexistent_project(driver):
    """
    Verificar se o sistema trata tentativa de deletar projeto inexistente
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    
    # Tentar deletar projeto que não existe
    projects_page.find_by_title_and_delete("Projeto Inexistente")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "projeto não encontrado" in erro.text.lower()

def test_create_project_special_characters(driver):
    """
    Verificar se o sistema trata corretamente títulos com caracteres especiais
    """
    login(driver)

    projects_page = ProjectsPage(driver)
    projects_page.load()
    projects_page.create_project()

    create_project_page = CreateProjectPage(driver)
    titulo_especial = "Projeto @#$%^&*()"
    create_project_page.create(titulo_especial, "Descrição Teste", "Objetivos Teste")

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "caracteres inválidos" in erro.text.lower()

def test_edit_project_without_permission(driver):
    """
    Verificar se o sistema impede edição de projeto por usuário sem permissão
    """
    # Assumindo que existe um projeto criado por outro usuário
    login(driver)  # Login com usuário sem permissão

    projects_page = ProjectsPage(driver)
    projects_page.load()
    
    # Tentar editar projeto de outro usuário
    driver.get(f"{projects_page.url}/edit/1")  # ID de um projeto existente

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "sem permissão" in erro.text.lower()

def test_delete_project_without_permission(driver):
    """
    Verificar se o sistema impede exclusão de projeto por usuário sem permissão
    """
    # Assumindo que existe um projeto criado por outro usuário
    login(driver)  # Login com usuário sem permissão

    projects_page = ProjectsPage(driver)
    projects_page.load()
    
    # Tentar deletar projeto de outro usuário
    driver.get(f"{projects_page.url}/delete/1")  # ID de um projeto existente

    erro = WebDriverWait(driver, 5).until(
        EC.visibility_of_element_located((By.XPATH, '//p[contains(@class, "error-message")]'))
    )
    assert "sem permissão" in erro.text.lower() 