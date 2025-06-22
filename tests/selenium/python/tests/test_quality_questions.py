import time
from selenium.webdriver.common.by import By
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.quality_assessment.quality_questions import qualityQuestionsPage
from utils.web_functions import login

title = "Meu Projeto Teste"

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

# SeTC008.1 - Criar uma Questão de Qualidade
def test_create_quality_question(driver):
    """
    Verificar se é possível criar questões de qualidade em um projeto.
    """
    id_quality_question = "QA01"
    description_quality_question = "Descrição da questão de qualidade"
    weight_quality_question = "10"

    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    quality_assessment_page = qualityQuestionsPage(driver)

    projects_page.load()
    time.sleep(1)
    quality_assessment_page.find_by_title_and_open(title)
    time.sleep(1)

    quality_assessment_page.create_quality_question(id_quality_question, description_quality_question, weight_quality_question)
    time.sleep(1)
    assert quality_assessment_page.find_qa_by_id(id_quality_question), f"A questão de qualidade com ID {id_quality_question} não foi criada com sucesso."

# SeTC008.2 - Editar uma Questão de Qualidade
def test_edit_quality_question(driver):
    """
    Verificar se é possivel editar uma questão de qualidade já existente.
    """
    id_quality_question = "QA01"
    new_id_quality_question = "QA02"
    new_description_quality_question = "Descrição nova"
    new_weight_quality_question = "123"

    login(driver)
    time.sleep(1)

    projects_page = ProjectsPage(driver)
    quality_assessment_page = qualityQuestionsPage(driver)

    projects_page.load()
    time.sleep(1)
    quality_assessment_page.find_by_title_and_open(title)
    time.sleep(1)

    quality_assessment_page.edit_quality_question(id_quality_question, new_id_quality_question, new_description_quality_question, new_weight_quality_question)
    time.sleep(1)

    assert quality_assessment_page.find_qa_by_id(new_id_quality_question), f"A questão de qualidade com ID {new_id_quality_question} não foi editada com sucesso."

# SeTC008.3 - Excluir uma Questão de Qualidade
def test_delete_quality_question(driver):
    """
    Verificar se é possível excluir uma questão de qualidade existente.
    """
    login(driver)
    time.sleep(1)

    id_quality_question = "QA02"

    projects_page = ProjectsPage(driver)
    quality_assessment_page = qualityQuestionsPage(driver)

    projects_page.load()
    time.sleep(1)
    quality_assessment_page.find_by_title_and_open(title)
    time.sleep(1)

    quality_assessment_page.delete_quality_question(id_quality_question)
    time.sleep(1)

    assert not quality_assessment_page.find_qa_by_id(id_quality_question), f"A questão de qualidade com ID {id_quality_question} não foi excluída com sucesso."
