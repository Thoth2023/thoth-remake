import time
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class StudySelectionPage:
    STUDY_SELECTION_BUTTON = (By.XPATH, "//*[@id='study-selection-tab']") 
    STUDY = (By.XPATH, "//ul[2]/div[4]/div[2]/span")
    INCLUSION = (By.XPATH, "//table/tbody/tr[1]/td[1]/input")
    EXCLUSION = (By.XPATH, "//table/tbody/tr[3]/td[1]/input")
    SUCCESS_OK_BUTTON = (By.XPATH, "//*[@id='successModal']/div/div/div[3]/button")
    CLOSE_BUTTON = (By.XPATH, "//*[@id='paperModal']/div/div/div[3]/button")
    REMOVE_BUTTON = (By.XPATH, "//*[@id='paperModal']/div/div/div[2]/div[3]/label[2]")
    UNCLASSIFIED_BUTTON = (By.XPATH, "//*[@id='paperModal']/div/div/div[2]/div[3]/label[1]")

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(driver, 10)

    def click(self, locator):
        self.wait.until(EC.element_to_be_clickable(locator)).click()

    def scroll_down(self, times=2):
        for _ in range(times):
            self.driver.find_element(By.TAG_NAME, 'body').send_keys(Keys.PAGE_DOWN)
             
    def scroll_down_modal(self):
        modal = self.driver.find_element(By.ID, "paperModal")
        self.driver.execute_script("arguments[0].scrollTop = arguments[0].scrollHeight;", modal)

    def open_study_selection(self):
        self.click(self.STUDY_SELECTION_BUTTON)

    def open_unclassified_study(self):
        self.scroll_down()
        self.click(self.STUDY)

    def inclusion_criteria(self):
        self.click(self.INCLUSION)
        time.sleep(1)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.scroll_down_modal()
        self.click(self.CLOSE_BUTTON)
        
    def exclusion_criteria(self):
        self.click(self.EXCLUSION)
        time.sleep(1)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.scroll_down_modal()
        self.click(self.CLOSE_BUTTON)

    def remove(self):
        self.click(self.INCLUSION)
        time.sleep(1)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.click(self.INCLUSION)
        time.sleep(1)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.scroll_down_modal()
        self.click(self.REMOVE_BUTTON)
        time.sleep(2)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.scroll_down_modal()
        self.click(self.CLOSE_BUTTON)

    def unclass(self):
        self.click(self.INCLUSION)
        time.sleep(1)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.click(self.INCLUSION)
        time.sleep(1)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.scroll_down_modal()
        self.click(self.UNCLASSIFIED_BUTTON)
        time.sleep(2)
        self.click(self.SUCCESS_OK_BUTTON)
        time.sleep(1)
        self.scroll_down_modal()
        self.click(self.CLOSE_BUTTON)
