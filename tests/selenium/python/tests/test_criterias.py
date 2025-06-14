import time
from pages.criteria.criteria import criteriaPage
from utils.web_functions import login

# SeTC.005.1 - Criar critério de Inclusão
def test_create_inclusion_criteria(driver):
    """
    Verificar se é possível criar um critério de Inclusão com os campos obrigatórios preenchidos.
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    id_criteria = "CI01"
    descricao = "Descricao"
    tipo = "Inclusion"
    criteria_page.create_criteria(id_criteria, descricao, tipo)
    time.sleep(1)

    assert criteria_page.find_criteria_by_id(id_criteria), f"O critério de Inclusão '{id_criteria}' não foi encontrado na tabela."

# SeTC.005.2 - Criar Critério de Exclusão
def test_create_exclusion_criteria(driver):
    """
    Verificar se é possível criar um critério de Exclusão com os campos obrigatórios preenchidos.
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    id_criteria = "CE01"
    descricao = "Descricao"
    tipo = "Exclusion"
    criteria_page.create_criteria(id_criteria, descricao, tipo)
    time.sleep(1)

    assert criteria_page.find_criteria_by_id(id_criteria), f"O critério de Exclusão '{id_criteria}' não foi encontrado na tabela."

# SeTC.005.3 - Editar um critério
def test_edit_criteria(driver):
    """
    Verificar se é possível editar um critério existente.
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    id_criteria = "CI01"
    novo_id_criteria = "C01"
    descricao = "Descricao nova"
    tipo = "Exclusion"
    criteria_page.edit_criteria(id_criteria, novo_id_criteria, descricao, tipo)
    time.sleep(1)

    assert not criteria_page.find_criteria_by_id(id_criteria), f"O critério com id '{id_criteria}' foi encontrado com os mesmos valores."

# SeTC 005.4 - Excluir um critério
def test_delete_criteria(driver):
    """
    Verificar se é possível excluir um critério existente.
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    id_criteria = "C01"
    criteria_page.delete_criteria(id_criteria)
    time.sleep(1)

    assert not criteria_page.find_criteria_by_id(id_criteria), f"O critério com id '{id_criteria}' foi encontrado na tabela após a exclusão."

# SeTC.005.5 - Modificar a regra do critério - Modificar regra para “todos”
def test_modify_criteria_rule_to_all(driver):
    """
    Verificar se é possível modificar a regra de um critério para "todos".
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    new_rule = "ALL"
    criteria_page.modify_criteria_rule(new_rule)
    time.sleep(1)

    assert criteria_page.verify_criteria_rule(new_rule), f"A regra do critério não foi modificada para '{new_rule}'."

# SeTC.005.6 - Modificar a regra do critério - Modificar regra para "qualquer"
def test_modify_criteria_rule_to_any(driver):
    """
    Verificar se é possível modificar a regra de um critério para "qualquer".
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    new_rule = "ANY"
    criteria_page.modify_criteria_rule(new_rule)
    time.sleep(1)

    assert criteria_page.verify_criteria_rule(new_rule), f"A regra do critério não foi modificada para '{new_rule}'."

#  SeTC.005.7 - Modificar a regra do critério - Modificar regra para "pelo menos"
def test_modify_criteria_rule_to_at_least(driver):
    """
    Verificar se é possível modificar a regra de um critério para "pelo menos".
    """
    login(driver)

    criteria_page = criteriaPage(driver)
    criteria_page.load()

    new_rule = "AT_LEAST"
    criteria_page.modify_criteria_rule(new_rule)
    time.sleep(1)

    assert criteria_page.verify_criteria_rule(new_rule), f"A regra do critério não foi modificada para '{new_rule}'."
