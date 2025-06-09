import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

class CreateProjectTest(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Chrome()
        self.driver.get("http://localhost:8000/projects/create")
        self.driver.maximize_window()
        time.sleep(5) 

    def test_create_project_successfully(self):
        driver = self.driver

        driver.find_element(By.NAME, "title").send_keys("Projeto Selenium Teste")

        driver.execute_script("document.querySelector('#descriptionEditor .ql-editor').innerHTML = 'Descrição do projeto';")
        driver.execute_script("document.querySelector('#objectivesEditor .ql-editor').innerHTML = 'Objetivos do projeto';")
        driver.execute_script("document.querySelector('#descriptionInput').value = 'Descrição do projeto';")
        driver.execute_script("document.querySelector('#objectivesInput').value = 'Objetivos do projeto';")

        select_element = Select(driver.find_element(By.ID, "copy_planning"))
        try:
            select_element.select_by_index(1) 
        except:
            select_element.select_by_visible_text("None")

        radio = driver.find_element(By.ID, "feature_review1")
        radio.click()

        submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
        submit_button.click()
        time.sleep(2)

        self.assertIn("projects", driver.current_url.lower())

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()