import time
from pages.projects.planning.data_extraction import DataExtractionPage
from utils.web_functions import login
from selenium.webdriver.common.by import By

def test_validate_question_switch_updates_form(driver):
    """
    Verifica se ao clicar para editar uma questão e depois outra,
    os dados no formulário realmente mudam, refletindo a segunda questão.
    """
    login(driver)

    # Acessa a página do projeto
    project_page = DataExtractionPage(driver)
    project_page.load()

    # Clica no botão "Abrir" do projeto
    project_page.open_project()

    # Abre aba de Planejamento
    project_page.click_data_extraction_tab()

    # Editar questão 1
    project_page.scroll_to_element_and_click("//tbody/tr[1]/td[5]/div[1]/button[1]")
    form_data_q1 = project_page.get_form_data()
    print(f"Dados Q1: {form_data_q1}")

    # Editar questão 2
    project_page.scroll_to_element_and_click("//tbody/tr[2]/td[5]/div[1]/button[1]")
    time.sleep(20)
    form_data_q2 = project_page.get_form_data()
    print(f"Dados Q2: {form_data_q2}")

    # Verifica se apareceu o alerta
    #assert project_page.check_id_conflict_alert(),"Alerta não apareceu"
    # Validação: os dados devem ser diferentes
    assert form_data_q1 != form_data_q2, "Os dados do formulário não mudaram ao trocar de questão"

def test_create_question_with_missing_data(driver):
    """
    Testa se o sistema bloqueia o cadastro de uma questão sem preencher os campos obrigatórios.
    """
    login(driver)

    project_page = DataExtractionPage(driver)
    project_page.load()
    project_page.open_project()
    project_page.click_data_extraction_tab()

    # Tenta salvar sem preencher nada
    project_page.save_question()

    # Check if validation errors are displayed
    assert project_page.check_validation_error(), "O sistema permitiu cadastro sem preencher dados obrigatórios."

def test_create_question_with_existing_id(driver):
    """
    Testa se o sistema impede a criação de uma questão com ID já existente.
    """
    login(driver)
    project_page = DataExtractionPage(driver)
    project_page.load()
    project_page.open_project()
    project_page.click_data_extraction_tab()

    # Preencher com ID já existente
    project_page.fill_question_form("Q1", "Tentando criar com ID duplicado", "Text")
    project_page.save_question()

    # Verificar se apareceu o alerta de conflito de ID
    assert project_page.check_id_conflict_alert(), "O alerta de ID duplicado não apareceu."
    
def test_edit_existing_question(driver):
    """
    Testa se é possível editar uma questão existente.
    """
   
    login(driver)
    project_page = DataExtractionPage(driver)
    project_page.load()
    project_page.open_project()
    project_page.click_data_extraction_tab()

    # Clica para editar a questão
    project_page.scroll_to_element_and_click("//tbody/tr[1]/td[5]/div[1]/button[1]")
    time.sleep(20)

    # Edita a descrição
    project_page.edit_question_description("Descrição editada")
    project_page.save_question()
    time.sleep(20)

    # Valida se a descrição foi alterada na tabela
    data = project_page.get_question_data_by_id("Q1")
    assert data["descricao"] == "Descrição editada", "A descrição não foi atualizada corretamente."