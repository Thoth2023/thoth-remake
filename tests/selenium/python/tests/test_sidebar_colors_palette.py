import time
from pages.perfil import PerfilPage

# Testa se todas as cores personalizadas da barra lateral funcionam corretamente
def test_todas_cores_personalizadas_sidebar(driver):
    pagina = PerfilPage(driver)
    pagina.acessar()
    time.sleep(2)  # Aguarda o carregamento da página

    # Lista dos IDs dos botões de cores
    botoes_cores = [
        "cor-1",  # exemplo: Azul
        "cor-2",  # exemplo: Vermelho
        "cor-3",  # exemplo: Verde
        "cor-4",  # exemplo: Amarelo
        "cor-5",  # exemplo: Roxo
        "cor-6",  # exemplo: Laranja
    ]

    cores_aplicadas = []  # Armazena as cores aplicadas na barra lateral

    # Clica em cada botão de cor e guarda a cor resultante
    for botao_id in botoes_cores:
        botao = pagina.botao_cor_personalizada(botao_id)
        botao.click()
        time.sleep(1)

        # Captura a cor da barra lateral após aplicar a cor
        cor_atual = pagina.barra_lateral().value_of_css_property("background-color")
        cores_aplicadas.append(cor_atual)

    # Verifica se todas as cores aplicadas são diferentes entre si
    assert len(set(cores_aplicadas)) == len(botoes_cores), "Nem todas as cores da barra lateral foram aplicadas corretamente."
