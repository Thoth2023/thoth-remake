import time
from pages.projects.index import ProjectsPage
from pages.projects.create import CreateProjectPage
from pages.team.index import TeamPage
from utils.web_functions import login

# SeTC.003.2 - Adicionar membro
def test_add_member(driver):
    """
    Verificar se é possível adicionar um membro à equipe do projeto.
    """
    login(driver)

    team_page = TeamPage(driver)
    team_page.load()
    team_page.open_add_member()
    sleep_time = 1  # Tempo de espera para garantir que a página carregue corretamente
    time.sleep(sleep_time)  # Aguarda o carregamento da janela de adicionar membro
    team_page.add_member("miguelmuniz.aluno@unipampa.edu.br")
    time.sleep(sleep_time)  # Aguarda o carregamento após adicionar o membro
    team_page.alter_member("miguelmuniz.aluno@unipampa.edu.br")
    time.sleep(sleep_time)  # Aguarda o carregamento após alterar o membro
