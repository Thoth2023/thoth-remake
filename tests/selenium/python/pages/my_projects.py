from selenium.webdriver.common.by import By
from utils.config import BASE_URL

class MyProjectsPage:
    URL = BASE_URL + 'projects'
    
    FIRST_PROJECT = (By.XPATH, "/html/body/main/div[1]/div[1]/div/div/div/div/div[2]/div/table/tbody/tr[1]/td[4]/div/div[1]/a[1]")
    
    def __init__(self, driver):
        self.driver = driver

    def load(self):
        self.driver.get(self.URL)
        
    def open_first_project(self):
        self.driver.find_element(*self.FIRST_PROJECT).click()