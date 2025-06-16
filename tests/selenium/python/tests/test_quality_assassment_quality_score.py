import time
from pages.quality_assessment_quality_score import QualityAssessmentQualityScore
from utils.web_functions import login

# SeTC.009.1 - Criar Pontuação de Questão de Qualidade
def test_create_quality_score(driver):
    """
    Verificar se é possível criar a pontuação para questões de qualidade dos projetos
    """
    login(driver)

    qa_quality_score_page = QualityAssessmentQualityScore(driver)
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.create_question_score("0/4", 0, "Atingiu 0/4")
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.create_question_score("1/4", 25, "Atingiu 1/4")
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.create_question_score("2/4", 50, "Atingiu 2/4")
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.create_question_score("3/4", 75, "Atingiu 3/4")
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.create_question_score("4/4", 100, "Atingiu 4/4")
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.toggle_menu()
    first_tab = qa_quality_score_page.get_first_tab()
    last_tab = qa_quality_score_page.get_last_tab()

    assert first_tab == "0/4", f"Esperado '0/4' como primeira tab, mas obteve '{first_tab}'"
    assert last_tab == "4/4", f"Esperado '4/4' como última tab, mas obteve '{last_tab}'"


# SeTC.009.2 - Editar Pontuação de Questão de Qualidade
def test_edit_quality_score(driver):
    """
    Verificar se é possível editar a pontuação para questões de qualidade dos projetos
    """
    login(driver)

    qa_quality_score_page = QualityAssessmentQualityScore(driver)
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.toggle_menu()
    qa_quality_score_page.open_edit()
    time.sleep(2)
    qa_quality_score_page.edit_question("5/4", 80, "Alteração")

    qa_quality_score_page.navigate_to_quality_assessment()
    qa_quality_score_page.toggle_menu()

    first_tab = qa_quality_score_page.get_first_tab()
    assert first_tab == "5/4", f"Esperado '5/4' como primeira tab, mas obteve '{first_tab}'"


# SeTC.009.3 - Excluir Pontuação de Questão de Qualidade
def test_delete_quality_score(driver):
    """
    Verificar se é possível deletar a pontuação para questões de qualidade dos projetos
    """
    login(driver)

    qa_quality_score_page = QualityAssessmentQualityScore(driver)
    qa_quality_score_page.navigate_to_quality_assessment()

    qa_quality_score_page.toggle_menu()
    qa_quality_score_page.delete_quality()

    qa_quality_score_page.navigate_to_quality_assessment()
    qa_quality_score_page.toggle_menu()

    first_tab = qa_quality_score_page.get_first_tab()
    assert first_tab == "1/4", f"Esperado '1/4' como primeira tab, mas obteve '{first_tab}'"

    for i in range(4):
        qa_quality_score_page.navigate_to_quality_assessment()
        qa_quality_score_page.toggle_menu()
        qa_quality_score_page.delete_quality()
        time.sleep(0.05)
