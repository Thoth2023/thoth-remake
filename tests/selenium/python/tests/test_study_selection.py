import time
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.projects.tabs.view import ViewProjectPage
from utils.web_functions import login
from pages.projects.conducting.study_selection import StudySelection
import pytest
import os
import inspect

@pytest.fixture(autouse=True)
def wait_between_tests():
    yield
    time.sleep(2)

FINAL_MESSAGE = "✅ teste finalizado"
PROJECT_NAME = "Test Project"

DOWNLOAD_DIR = os.path.join(os.path.expanduser("~"), "Downloads")
FILE_NAME = "studies-selection"


def log_inicio_teste():
    caller = inspect.currentframe().f_back.f_code.co_name
    return f"⏳ Início do teste: {caller}"

def test_export_study_selection_csv(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    expected_header = "ID,Title,I/E Criteria,Database,Status,Peer Review"
    success, file_content = study_selection.verify_csv(f"{FILE_NAME}.csv", expected_header)
    assert success, f"CSV não contém o cabeçalho esperado.\nConteúdo:\n{file_content}"


def test_export_study_selection_pdf(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    expected_text = "ID Title I/E Criteria Database Status Peer Review"
    success, file_content = study_selection.verify_pdf(f"{FILE_NAME}.pdf", expected_text)
    assert success, f"PDF não contém os campos esperados.\nTexto extraído:\n{file_content}"


def test_export_study_selection_xml(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    expected_text = "<study_selection>Study Selection, Researcher: 123@!"
    success, file_content = study_selection.verify_xml(f"{FILE_NAME}.xml", expected_text)
    assert success, f"XML não contém o texto esperado.\nConteúdo:\n{file_content}"
    print(FINAL_MESSAGE)


def test_find_duplicated_papers(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    returned_message = study_selection.find_duplicates()
    expected_message = "Não foram encontrados papers Duplicados."
    assert expected_message in returned_message, "Mensagem não encontrada."


def test_search_existing_article(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    search_term = "deep learning"
    result = study_selection.search(search_term)
    assert search_term.lower() in result.lower(), "Mensagem não encontrada."


def test_search_nonexistent_article(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    search_term = "teste de artigo nao existente"
    result = study_selection.search_timeout(search_term)
    print("Resultado da busca:", result)
    assert result is None or result == "", "Resultado inesperado para artigo inexistente."


def test_open_doi_link(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    expected_domain = "sciencedirect.com"
    current_url = study_selection.navigate_to_doi()
    assert expected_domain in current_url, f"URL não corresponde ao domínio esperado: {expected_domain}"


def test_open_url_link(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    expected_domain = "sciencedirect.com"
    current_url = study_selection.navigate_to_url()
    assert expected_domain in current_url, f"URL não corresponde ao domínio esperado: {expected_domain}"


def test_open_google_scholar_link(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    expected_domain = "scholar.google.com"
    current_url = study_selection.navigate_to_google_scholar()
    assert expected_domain in current_url, f"URL não corresponde ao domínio esperado: {expected_domain}"


def test_accept_study(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    title = "AI-assisted facial analysis in healthcare: From disease detection to comprehensive management"
    returned_message = study_selection.accept_study(title)

    expected_message = "Aceito"
    assert expected_message in returned_message, "Mensagem de aceitação não encontrada."


def test_reject_study(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    title = "AI-assisted facial analysis in healthcare: From disease detection to comprehensive management"
    returned_message = study_selection.reject_study(title)

    expected_message = "Rejeitado"
    assert expected_message in returned_message, "Mensagem de rejeição não encontrada."
def test_filter_study(driver):
    print(log_inicio_teste())
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    returned_message = study_selection.filter_database()

    expected_message = "ACM (Association for Computing Machinery)"
    assert expected_message in returned_message, "Base de dados divergente."

def test_filter_first_accepted_study(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    status = study_selection.filter_and_check_first_study_status(
        StudySelection.FILTER_OPTION_ACCEPTED
    )

    assert "Aceito" in status

def test_filter_first_rejected_study(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    status = study_selection.filter_and_check_first_study_status(
        StudySelection.FILTER_OPTION_REJECTED
    )

    assert "Rejeitado" in status

def test_filter_first_unclassified_study(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    status = study_selection.filter_and_check_first_study_status(
        StudySelection.FILTER_OPTION_UNCLASSIFIED
    )

    assert "Não Classificado" in status


def test_filter_first_removed_study(driver):
    study_selection = StudySelection(driver)
    study_selection.open_project(PROJECT_NAME)
    study_selection.open_study_selection_tab()

    status = study_selection.filter_and_check_first_study_status(
        StudySelection.FILTER_OPTION_REMOVED
    )

    assert "Removido" in status
